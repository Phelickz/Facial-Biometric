#importing Flask
from flask import Flask, jsonify,abort,make_response
from flask import request,Response
import http.client, urllib.request, urllib.parse, urllib.error, base64
from urllib.parse import urlencode, quote_plus
import requests
import secrets,datetime
import jwt,json
from flask_httpauth import HTTPBasicAuth , HTTPTokenAuth # API 
from flask_sqlalchemy import SQLAlchemy # import SQLAlchemy
from sqlalchemy import desc,and_
from flask_marshmallow import Marshmallow # Flask + marshmallow for beautiful APIs to convert SQLAlchemy to jason
from functools import wraps
from database import User,Token,Enroll,Upload
from flask_cors import CORS, cross_origin
auth = HTTPBasicAuth()
authToken = HTTPTokenAuth(scheme='Token')


#start App
app = Flask(__name__)
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///face.db'

db = SQLAlchemy(app) # Creating database Object form SQLAlchemy

CORS(app)
app.config['SECRET_KEY'] ='0307beb835b20ea53845e3230a7d8d6907dcc5957546580e044c846065da0bd7'
ma = Marshmallow(app) # Creating database Object form Marshmallow




# Create A SCHEMA for User Marshmallow
class UserSchema(ma.ModelSchema):
    class Meta:
        model = User 

# Create A SCHEMA for Token Marshmallow
class TokenSchema(ma.ModelSchema):
    class Meta:
        model = Upload

#SECURE ROUTE USING BASIC AUTH
@auth.get_password
def get_pw(username):
   user = User.query.filter_by(username=username).first()
   if user is not None:
       return user.password
   else:
       return None




#PROTECTED ROUTE WITH TOKEN CALL
def token_required(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        token=None
        if 'aws-token' in request.headers:
            token =request.headers['aws-token']
        
        if not  token:
            return jsonify({'msg': 'Token is missing'}), 401
        try:
            data=jwt.decode(token,app.config['SECRET_KEY'] )
            current_data=data # pass the decode that within the token 
        except:
            return jsonify({'msg': 'Invalid Token'}), 403

        return f(current_data,*args,**kwargs)
    return decorated


# error to stop alert form using browser
@authToken.error_handler
@auth.error_handler
def unauthorized():
    return make_response(jsonify({'error': 'Unauthorized access'}), 401)
#let make a json error call to display nice error call
@authToken.error_handler
@auth.error_handler
def unauthorized():
    return make_response(jsonify({'error': 'Unauthorized access'}), 403)
@app.errorhandler(404)
def not_found(error):
    return make_response(jsonify({'error': 'Not found'}), 404)
@app.errorhandler(400)
def bad_request(error):
    return make_response(jsonify({'error': 'Bad request'}), 400)
@app.errorhandler(405)
def method_not(error):
    return make_response(jsonify({'error': 'Method Not Allow'}), 405)
@app.errorhandler(500)
def server_error(error):
    return make_response(jsonify({'error': 'Internal Server Error'}), 500)


#*********************FUNCTION CALL******************
#Check & delete  expire token call not in used
def expire_token():
    expiration_time = 10
    limit = datetime.datetime.now() - datetime.timedelta(minutes=expiration_time)
    Token.query.filter(Token.created_time <= limit).delete()
    db.session.commit()




# CREATE PARTION  with SQLAlchemy
@app.route('/app/api/v1.0/partition',methods=['POST'])
def partition():
    if not request.json or not 'partition' in request.json:
        abort(400)
    username=request.json['username']
    password=request.json['password']
    partition=request.json['partition']
    service=request.json['service']
    userData=User(username=username,password=password,partition=partition,service=service)
    db.session.add(userData)
    db.session.commit()
    msg = "Partition Created successfully"
    #return jsonify(msg.json())
    return jsonify({'msg': msg}), 201



#VIEW  PARTITIONS Create
@app.route('/app/api/v1.0/partition/view',methods=['GET'])
def view_partition():
    rows = User.query.all()
    user_schema=UserSchema(many=True)
    result=user_schema.dump(rows).data
    return jsonify({'data': result}), 201



# Generate Token to strat  Biomentric operation  with successful ASW AUTH 
@app.route('/app/api/v1.0/api/token',methods=['GET'])
@auth.login_required # securing the api route
def token_generate():
    #Retrieving Query String Parameters
    partition=request.args['partition'];
    callID=request.args['callID'];
    awsTask=request.args['task']
    results=User.query.filter_by(partition = partition).all()

    if len(results)==0:
        return make_response( jsonify({'msg': 'Invalid Partition '}), 402)
    else:
        for result in results:
            awsUser=result.username
            awsPartition=result.partition
        #encode all  return data to the  token
        token=jwt.encode({'awsPartition': awsPartition,'callID': callID,'awsUser': awsUser, 'awsTask': awsTask,'exp' : datetime.datetime.utcnow()+ datetime.timedelta(minutes=10)},app.config['SECRET_KEY'])
        # return jsonify({'token': token.decode('UTF-8')}), 201
        return token.decode('UTF-8')
    

 #Token view Using SCHEMA TO DISPLAY SQLALCHEMY
@app.route('/app/api/v1.0/token/view',methods=['GET'])
def view_token():
    rows = Upload.query.all()
    token_schema=TokenSchema(many=True)
    result=token_schema.dump(rows).data
    return jsonify({'data': result}), 201   


#####################################################################################################################################
#                                        SETTING LARGEPERSON GROUP
#
######################################################################################################################################




#setting the server and partition with Azure to perform identification [LargePersonGroup]
#CreateLargePerson
@app.route('/app/api/v1.0/lgp',methods=['PUT'])
@token_required # securing the api route with generated token 
def LargePersonGroup(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"
    url = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largepersongroups/largePersonGroupId"
    partition=request.args['partition'];
    #name=request.args['name'];
      #Parameter to pass
    headers = {
    # Request headers
    'Content-Type': 'application/json',
    'Ocp-Apim-Subscription-Key': subscription_key,
     'cache-control': "no-cache"
    }
   
    payload = "{\r\n    \"name\": \""+current_data['awsUser']+"\",\r\n    \"userData\": \"No User  data attached to partition.\"\r\n}"

    params  = {"largePersonGroupId": partition}
    response = requests.request("PUT",url, data=payload, headers=headers, params=params)
    responseValue=response.text
    if not responseValue:
        return make_response( jsonify({'msg': 'Partition was Created successfully'}), 200)
    else:
        return jsonify(response.json())
    
        
   

#View Created Large Person by Partition

@app.route('/app/api/v1.0/lgp/group',methods=['GET'])
@token_required # securing the api route with generated token 
def get_lpg(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"
    url = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largepersongroups/largePersonGroupId"
    partition=request.args['partition'];
      #Parameter to pass
    headers = {
    # Request headers
    'Content-Type': 'application/json',
    'Ocp-Apim-Subscription-Key': subscription_key,
     'cache-control': "no-cache"
    }

    params  = {"largePersonGroupId": partition}
    
    response = requests.request("GET",url,  headers=headers, params=params)
    return jsonify(response.json())



#GET All Large Person  Partition

@app.route('/app/api/v1.0/lgp/group/all',methods=['GET'])
@token_required # securing the api route with generated token 
def get_lpg_all(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"
    url = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largepersongroups"
    
      #Parameter to pass
    headers = {
    # Request headers
    'Content-Type': 'application/json',
    'Ocp-Apim-Subscription-Key': subscription_key,
     'cache-control': "no-cache"
    }

    params  = {}
    
    response = requests.request("GET",url,  headers=headers, params=params)
    return jsonify(response.json())



#Delete Large Person Group

@app.route('/app/api/v1.0/lgp/delete',methods=['DELETE'])
@token_required # securing the api route with generated token 
def delete_lpg(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"
    url = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largepersongroups/largePersonGroupId"
    partition=request.args['partition'];
      #Parameter to pass
    headers = {
    # Request headers
    'Content-Type': 'application/json',
    'Ocp-Apim-Subscription-Key': subscription_key,
     'cache-control': "no-cache"
    }

    params  = {"largePersonGroupId": partition}
    
    response = requests.request("DELETE",url,  headers=headers, params=params)
    responseValue=response.text
    if not responseValue:
        return make_response( jsonify({'msg': 'Partition was Deleted successfully'}), 200)
    else:
        return jsonify(response.json())



  #LargePersonGroup - Train : The training task is an asynchronous task.

@app.route('/app/api/v1.0/lgp/train',methods=['POST'])
@token_required # securing the api route with generated token 
def LargePersonGroupTrain(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"
    url = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largepersongroups/"+current_data['awsPartition']+"/train"
      #Parameter to pass
    headers = {
    # Request headers
    'Content-Type': 'application/json',
    'Ocp-Apim-Subscription-Key': subscription_key,
     'cache-control': "no-cache"
    }
    
    response = requests.request("POST",url, headers=headers)
    responseValue=response.text
    if not responseValue:
        return make_response( jsonify({'msg': 'Partition was  successfully Train'}), 200)
    else:
        return jsonify(response.json())
    
    
#GET train Status

@app.route('/app/api/v1.0/lgp/train/status',methods=['GET'])
@token_required # securing the api route with generated token 
def get_train_status(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"
    url = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largepersongroups/"+current_data['awsPartition']+"/training"
      #Parameter to pass
    headers = {
    # Request headers
    'Content-Type': 'application/json',
    'Ocp-Apim-Subscription-Key': subscription_key,
     'cache-control': "no-cache"
    }
    
    response = requests.request("GET",url,  headers=headers)
    return jsonify(response.json())



#####################################################################################################################################
#                                        SETTING PERSONS ID IN THE ;LARGE PERSON GROUP STARTING ENRROLLMENT 
#
######################################################################################################################################



#GET All Large PersonGroup person Details

@app.route('/app/api/v1.0/person/all',methods=['GET'])
@token_required # securing the api route with generated token 
def get_person_all(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"
    url = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largepersongroups/"+current_data['awsPartition']+"/persons"
    
      #Parameter to pass
    headers = {
    # Request headers
    'Content-Type': 'application/json',
    'Ocp-Apim-Subscription-Key': subscription_key,
     'cache-control': "no-cache"
    }

    #params  = {"largePersonGroupId": current_data['partition']}
    
    response = requests.request("GET",url,  headers=headers)
    return jsonify(response.json())




#####################################################################################################################################
#                                        SETTING  LARGEFACE LIST FOR FACE SEARCH
#
######################################################################################################################################




#setting the server and partition with Azure to perform identification [LargePersonGroup]
#CreateLargePerson
@app.route('/app/api/v1.0/fs',methods=['PUT'])
@token_required # securing the api route with generated token 
def LargeFaceList(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"
    url = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largefacelists/largeFaceListId"
    partition=request.args['partition'];
    #name=request.args['name'];
      #Parameter to pass
    headers = {
    # Request headers
    'Content-Type': 'application/json',
    'Ocp-Apim-Subscription-Key': subscription_key,
     'cache-control': "no-cache"
    }
   
    payload = "{\r\n    \"name\": \""+current_data['awsUser']+"\",\r\n    \"userData\": \"No User  data attached to partition.\"\r\n}"

    params  = {"largeFaceListId": partition}
    response = requests.request("PUT",url, data=payload, headers=headers, params=params)
    responseValue=response.text
    if not responseValue:
        return make_response( jsonify({'msg': 'Face List Partition was Created successfully'}), 200)
    else:
        return jsonify(response.json())
    



@app.route('/app/api/v1.0/fs/all',methods=['GET'])
@token_required # securing the api route with generated token 
def get_fs_all(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"
    url = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largefacelists"
    
      #Parameter to pass
    headers = {
    # Request headers
    'Content-Type': 'application/json',
    'Ocp-Apim-Subscription-Key': subscription_key,
     'cache-control': "no-cache"
    }

    params  = {}
    
    response = requests.request("GET",url,  headers=headers, params=params)
    return jsonify(response.json())


#####################################################################################################################################
#                                        START BIOMETRIC CALLS
#
######################################################################################################################################
#-----------------------------------------BIOMETRIC CALLS-----------------------------------------
# A route to return all of the available entries in our catalog.
# this route to the api get funtion using the get method/ only for the GET HTTP method.


#Upload person to prepare for BioMetric

@app.route('/app/api/v1.0/upload', methods=['POST']) 
@token_required # securing the api route with generated token
def get_upload(current_data):
    if not request.json or not 'index' in request.json:
        abort(400)
    dataUrl=request.json['DataUrl']
    index=request.json['index']
    
    with open("upload/"+current_data['awsPartition']+ current_data['callID'] +index+".png", "wb") as fh:
        fh.write(base64.decodebytes(dataUrl.encode()))
    
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"
    image_url = "http://aws.appmartgroup.com/upload/"+current_data['awsPartition']+ current_data['callID'] +index+".png"
    face_api_url = 'https://westeurope.api.cognitive.microsoft.com/face/v1.0/detect'

    #Parameter to pass
    headers = {
    'Content-Type': 'application/json',
    'Ocp-Apim-Subscription-Key': subscription_key
    }
    params = {
        'returnFaceId': 'true',
        'returnFaceAttributes': 'blur,exposure,noise'
    }

    data = {'url': image_url}

    response = requests.post(face_api_url, params=params, headers=headers, json=data)
    results=response.json()
    awsfaceId= results[0]
    if not awsfaceId['faceId']:
        return jsonify({ "Accepted": False, "Error":'No Face Found'}),403
    else:
       #return jsonify({'awsPersonId':awsPersonId})
       UploadData=Upload(partition=current_data['awsPartition'],faceId=awsfaceId['faceId'],callID=current_data['callID'],Image=image_url,personId=awsfaceId['faceId'],task=current_data['awsTask'] )
       db.session.add(UploadData)
       db.session.commit()
       msg = "Upload successfully"
       return jsonify({"Accepted": True}), 201
    




#CREATE - LargePersonGroup Person - Create and add face (Enroll)

@app.route('/app/api/v1.0/enroll',methods=['POST'])
@token_required # securing the api route with generated token 
def Person_create(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"
    url = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largepersongroups/largePersonGroupId/persons"
    
      #Parameter to pass
    headers = {
    # Request headers
    'Content-Type': 'application/json',
    'Ocp-Apim-Subscription-Key': subscription_key,
     'cache-control': "no-cache"
    }
    payload = "{\r\n    \"name\": \"Aws\",\r\n    \"userData\": \"No data attached .\"\r\n}"
    params  = {"largePersonGroupId": current_data['awsPartition']}
    
    response = requests.request("POST",url, data=payload, headers=headers, params=params)
    results=response.json()

    awsPersonId= results['personId']
    if not awsPersonId:
        return jsonify({'msg': results})
    else:
       #return jsonify({'awsPersonId':awsPersonId})
       ImgUrls=Upload.query.filter_by(callID = current_data['callID'],partition=current_data['awsPartition']).order_by(desc(Upload.id)).limit(1).all()
       for ImgUrl in ImgUrls:
             
            #ADDING FACE TO A PERSON GROUP CREATED
            AddFaceUrl = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largepersongroups/"+current_data['awsPartition']+"/persons/"+awsPersonId+"/persistedfaces"
            image_url=ImgUrl.Image
            data = {'url': image_url}
            FaceResponse = requests.request("POST",AddFaceUrl,  headers=headers,  json=data)
            Awsresults=FaceResponse.json()
            awspersistedFaceId= Awsresults['persistedFaceId']

    
            EnrollData=Enroll(partition=current_data['awsPartition'],personId=awsPersonId,callID=current_data['callID'],persistedFaceId=awspersistedFaceId,task=current_data['awsTask'])
            db.session.add(EnrollData)
            db.session.commit()
            msg = "Enrollment successfully"

            #Return Enroment successfully but keep processing Training 
            

            #Train Pratition for Identify 
            TrainUrl = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largepersongroups/"+current_data['awsPartition']+"/train"
            responseTrain = requests.request("POST",TrainUrl, headers=headers)
            responseValue=responseTrain.text
            if not responseValue:
                 return jsonify({'msg': msg}), 201
            else:
                 return jsonify({'error': responseValue})
           #On successful personid is generated...this personId will be use to add a face which perform enrollment
    



@app.route('/app/api/v1.0/qualitycheck', methods=['POST']) 
@token_required # securing the api route with generated token
def get_qualitycheck(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"

    image_url = 'https://biotest.appmartgroup.com//assets/enroll/Api_pull/ASID254804002.png'
    face_api_url = 'https://westeurope.api.cognitive.microsoft.com/face/v1.0/detect'

    #Parameter to pass
    headers = {'Ocp-Apim-Subscription-Key': subscription_key}
    params = {
        'returnFaceId': 'true',
        'returnFaceLandmarks': 'true',
        'returnFaceAttributes': 'age,gender,headPose,smile,facialHair,glasses,' +
        'emotion,hair,makeup,occlusion,accessories,blur,exposure,noise'
    }

    data = {'url': image_url}

    response = requests.post(face_api_url, params=params, headers=headers, json=data)
    return jsonify(response.json())






#IDENTIFY Person Within a Large Person Group 

@app.route('/app/api/v1.0/identy', methods=['POST']) 
@token_required # securing the api route with generated token
def get_identify(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"


    url = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/identify"

    #Parameter to pass
    headers = {'Ocp-Apim-Subscription-Key': subscription_key}

    faceIds=Upload.query.filter_by(callID = current_data['callID'],partition=current_data['awsPartition']).order_by(desc(Upload.id)).limit(1).all()
    if len(faceIds)==0:
        return make_response( jsonify({'msg': 'Invalid Token : can not perform identification '}), 403)
    else:
       for faceId in faceIds:
            payload = "{\r\n    \"largePersonGroupId\": \""+ current_data['awsPartition']+"\",\r\n    \"faceIds\": [\r\n        \""+faceId.faceId+"\"\r\n    ],\r\n    \"maxNumOfCandidatesReturned\": 20,\r\n  \"confidenceThreshold\": \"0.1\"\r\n}"
            #payload = "{\r\n    \"largePersonGroupId\": \"sample_group\",\r\n    \"faceIds\": [\r\n        \"c5c24a82-6845-4031-9d5d-978df9175426\"\r\n    ],\r\n    \"maxNumOfCandidatesReturned\": 1,\r\n    \"confidenceThreshold\": 0.5\r\n}"
            response = requests.request("POST",url, data=payload, headers=headers)

            #Return All Matching Record 
            return jsonify(response.json())





#CREATE - LargePersonGroup Person - Create and add face (Enroll)IN USED

@app.route('/app/api/v1.0/face/enroll',methods=['POST'])
@token_required # securing the api route with generated token 
def Face_create(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"
    
      #Parameter to pass
    headers = {
    # Request headers
    'Content-Type': 'application/json',
    'Ocp-Apim-Subscription-Key': subscription_key,
     'cache-control': "no-cache"
    }
    #return jsonify({'awsPersonId':awsPersonId})
    ImgUrls=Upload.query.filter_by(callID = current_data['callID'],partition=current_data['awsPartition']).order_by(desc(Upload.id)).limit(1).all()
    for ImgUrl in ImgUrls:
             
        #ADDING FACE TO A PERSON GROUP CREATED
        AddFaceUrl = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largefacelists/"+current_data['awsPartition']+"/persistedfaces"
        image_url=ImgUrl.Image
        data = {'url': image_url}
        FaceResponse = requests.request("POST",AddFaceUrl,  headers=headers,  json=data)
        Awsresults=FaceResponse.json()
        awspersistedFaceId= Awsresults['persistedFaceId']


        EnrollData=Enroll(partition=current_data['awsPartition'],callID=current_data['callID'],persistedFaceId=awspersistedFaceId,task=current_data['awsTask'])
        db.session.add(EnrollData)
        db.session.commit()
        msg = "Face Enrollment successfully"

        #Return Enroment successfully but keep processing Training 
        

        #Train Pratition for Identify 
        TrainUrl = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/largefacelists/"+current_data['awsPartition']+"/train"
        responseTrain = requests.request("POST",TrainUrl, headers=headers)
        responseValue=responseTrain.text
        if not responseValue:
             return jsonify({'msg': msg}), 201
        else:
             return jsonify({'error': responseValue})
       #On successful personid is generated...this personId will be use to add a face which perform enrollment




#IDENTIFY Person Within a Large Person Group 

@app.route('/app/api/v1.0/face/identy', methods=['POST']) 
@token_required # securing the api route with generated token
def face_identify(current_data):
    subscription_key = "689818b8d4eb48268ec6bb29c04daebb"


    url = "https://westeurope.api.cognitive.microsoft.com/face/v1.0/findsimilars"

    #Parameter to pass
    headers = {'Ocp-Apim-Subscription-Key': subscription_key}
    results = []
    faceIds=Upload.query.filter_by(callID = current_data['callID'],partition=current_data['awsPartition']).order_by(desc(Upload.id)).limit(1).all()
    if len(faceIds)==0:
        return make_response( jsonify({'msg': 'Invalid Token : No sample to  perform identification '}), 403)
    else:
       for faceId in faceIds:
            payload = "{\r\n    \"faceId\": \""+faceId.faceId+"\",\r\n    \"largeFaceListId\": \""+ current_data['awsPartition']+"\",\r\n    \"maxNumOfCandidatesReturned\": 20,\r\n    \"mode\": \"matchFace\"\r\n}"
           
            response = requests.post(url, data=payload, headers=headers)
            faces=response.json()
    #Return All Matching Record 
            for face in faces:
                Awsface=Enroll.query.filter_by(persistedFaceId=face['persistedFaceId']).limit(1).all()
                for faceA in Awsface:
                    Matches = {
                    'score' : face['confidence'],
                    'classID' : faceA.callID,
                    'storage' : 'aws',
                    'persistedFaceId' : faceA.persistedFaceId
                
                     }
                    results.append(Matches)
            return jsonify({'Matches' :results})
            #return jsonify(response.json())
            

            





@app.route("/api/v1/users", methods=["POST"])
@token_required # securing the api route with generated token
def list_users(current_data):
    dataUrl="upload/"
    return jsonify({"Accepted": True , "DataUrl" : dataUrl}), 201



    #Delete APi 
@app.route('/app/api/v1.0/json', methods=['POST'])
@token_required # securing the api route with generated token 
def json_task(current_data):
    dataUrl=request.json['DataUrl']
    index=request.json['index']
    if not index:
        index=1
    

    with open("upload/"+current_data['awsPartition']+ current_data['callID'] +index+".png", "wb") as fh:
        fh.write(base64.decodebytes(dataUrl.encode()))
    return jsonify({"Accepted": True, "Warnings": [ "ImageTooSmall", "ImageTooBlurry" ]}), 201
    
#Start coding
@app.route('/')
@auth.login_required # securing the api route
def index():
  return auth.username() + ", You want to change your password"  
#   response  = requests.get('https://restcountries.eu/rest/v2/name/united')
#   return jsonify(response.json())

@app.route('/userLogin')
def loginUser():
    aut= request.authorization    
    if not aut:
        return make_response("Auth not verify",401)
    user = User.query.filter_by(username=aut.username).first()
    psd = User.query.filter_by(password=aut.password).first()
   
    if not user or not psd:
        return make_response("incorrect login details",401)
    else:
        return aut.username + ", You want to change your password" 

@app.route('/app/api/v1.0/uploadAWS', methods=['POST']) 
@token_required # securing the api route with generated token
def get_AWSupload(current_data):
    dataUrl=request.json['DataUrl']
    index=request.json['index']
   
    with open("upload/"+current_data['awsPartition']+ current_data['callID'] +index+".png", "wb") as fh:
        fh.write(base64.decodebytes(dataUrl.encode()))
    
    
    return jsonify({"Accepted": True}), 201
   
# This set dbug mode to enable reload new changes add to your app
if __name__=='__main__':
    app.run()

