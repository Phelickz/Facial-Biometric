from random import randint
from skimage.feature import greycomatrix,greycoprops
from skimage.measure import label,regionprops
from sklearn.model_selection import train_test_split
from imutils import paths
import os
import numpy as np
import cv2
import pandas as pd
import time

haarfile = "haarcascade_frontalface_alt.xml"
facedetectfile = cv2.CascadeClassifier(haarfile)
final = []
path = 'darkpoor.png'
#############################################################
        #Calculate the Histogram
         
 #############################################################               
if (path):  # WHEN WEBCAM IS OPENED
    frame = cv2.imread(path)
    image_grey = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)#CONVERT IMAGE TO GRAY SCALE
    faces = facedetectfile.detectMultiScale(image_grey)

    for x, y, w, h in faces:
        sub_img = frame[y - 10:y + h + 10, x - 10:x + w + 10]
        roi = frame[y:y+h, x:x+w]
        os.chdir("upload")
        cv2.imwrite(str(randint(0, 10000)) + ".jpg", sub_img) # SAVE AND RENAME THE FACE REGION

        # EXTRACTING THE FEATURES NOW FROM THE CROPPED IMAGE OF ONLY FRONTAL FACE         
        #print(int(faces[40, 40]))
        #Calculate the luminance with the face pixels

        
        cv2.rectangle(frame, (x, y), (x + w, y + h), (255, 255, 0), 2)
        #cv2.imshow("Frame", image_grey)
        #sub_img = cv2.resize(sub_img,256,256)
##########################################################################
        r = sub_img[110, 90, 0]
        g = sub_img[110, 70, 1]
        b = sub_img[110, 90, 2]
        # LUMINANCE FACTOR
        luminance = (0.2126 * r + 0.7152 * g + 0.0722 * b)
        print('Luminanace :')
        print(int(round(luminance)))
#############################################################
        #Cassifer
        histogram = [0] * 3
        for j in range(3):
            histr = cv2.calcHist([frame], [j], None, [256], [0, 256])
            histr *= 255.0 / histr.max()
            histogram[j] = histr
            #print('histogram :')
        ycrcb_hist= np.array(histogram)
        img_ycrcb = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
        

       
        
        

        ### MEAN RGB VALUE FOR LIVENESS DETECTION
        a = np.asarray(sub_img)
        image__mean = np.mean(sub_img, axis=0)
        
        print('******* THIS IS MEAN OF IMAGE********')
        print(image__mean)
        print('**************************************')
        time.sleep(2)

        ## SKEWNESS - STANDARD DEVIATION,TOTAL DATA_POINTS,MEAN OF DATA
        y_bar = np.mean(sub_img, axis=0)
        print()
        variance = np.var(a)
        sd = np.std(a)
        sdp_mean=np.std(image__mean)
        img_ycrcb_std= np.std(img_ycrcb)
        
        print("sdp_mean")
        print(sdp_mean)
        print("img_ycrcb")
        print(img_ycrcb_std)
        print('Luminanace :')
        print(int(round(luminance)))
        
        gray_image = cv2.cvtColor(sub_img, cv2.COLOR_BGR2GRAY)
        data_points = cv2.countNonZero(gray_image)
        lumm=int(round(luminance))
        #IMAGE BLUR calculating image bluriness
        fm = cv2.Laplacian(image_grey, cv2.CV_64F).var()
        print("Blurry No: "+str(fm))
        ##########
        if (data_points > 15000 and lumm < 250 and variance > 1700  and fm > 150
            ):
            print("Success")
            print(lumm)
            cv2.rectangle(frame, (x, y), (x + w, y + h), (0,255, 0), 2)
            sub_img = frame[y - 10:y + h + 10, x - 10:x + w + 10]
            os.chdir("C:\\Users\\kevin\\Downloads\\Original_Extracte")
            cv2.imwrite(str(1) + ".jpg", sub_img)
        else:
            print("Failed")
            cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 0, 255), 2)
            sub_img = frame[y - 10:y + h + 10, x - 10:x + w + 10]
            os.chdir("C:\\Users\\kevin\\Downloads\\Fake_Extracted")
            cv2.imwrite(str(0) + ".jpg", sub_img)

        time.sleep(3)
        print('variance', int(variance))
        print()
        print('standard deviation', int(sd))
        print()
        print('Data Points:', data_points)
        index = range(1,440)

                ########################################################################
        cv2.imshow("Faces Found", frame)
    
