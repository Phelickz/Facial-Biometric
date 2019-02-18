#importing Flask
from flask import Flask, jsonify,abort,make_response,request
from flask_sqlalchemy import SQLAlchemy # import SQLAlchemy
from flask_marshmallow import Marshmallow # Flask + marshmallow for beautiful APIs to convert SQLAlchemy to jason
import secrets,datetime


#start App
app = Flask(__name__)

app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///face.db'

db = SQLAlchemy(app) # Creating database Object form SQLAlchemy

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(20), unique=True, nullable=False)
    password= db.Column(db.String(80), nullable=False)
    partition = db.Column(db.String(80), unique=True, nullable=False)
    service = db.Column(db.String(10), nullable=False)

    def __repr__(self):
        return '<User %r>' % self.username


#Token Table
class Token(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    partition = db.Column(db.String(80),  nullable=False)
    callID = db.Column(db.String(10), nullable=False)
    personId = db.Column(db.String(255), unique=True, nullable=False)
    task = db.Column(db.String(20))
    created_time = db.Column(db.DateTime,  default=datetime.datetime.now())

    def __repr__(self):
        return '<Token %r>' % self.callID


 #Enroll Table
class Enroll(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    partition = db.Column(db.String(80),  nullable=False)
    callID = db.Column(db.String(10), nullable=False)
    personId = db.Column(db.String(255))
    persistedFaceId = db.Column(db.String(255))
    task = db.Column(db.String(20))
    created_time = db.Column(db.DateTime,  default=datetime.datetime.now())

    def __repr__(self):
        return '<Enroll %r>' % self.callID

        #Upload Table
class Upload(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    partition = db.Column(db.String(80),  nullable=False)
    callID = db.Column(db.String(10), nullable=False)
    Image = db.Column(db.Text, nullable=False)
    personId = db.Column(db.String(255))
    faceId = db.Column(db.String(255))
    task = db.Column(db.String(20))
    created_time = db.Column(db.DateTime,  default=datetime.datetime.now())

    def __repr__(self):
        return '<Upload %r>' % self.callID
# END DATABASE ONFIGURATION 
if __name__=='__main__':
    app.run(debug=True)