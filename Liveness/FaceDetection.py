import cv2
import numpy as np
from imutils import paths
from matplotlib import pyplot as plt

def variance_of_laplacian(image):
	# compute the Laplacian of the image and then return the focus
	# measure, which is simply the variance of the Laplacian
	return cv2.Laplacian(image, cv2.CV_64F).var()


img = cv2.imread('kk.png')
hsv = cv2.cvtColor(img,cv2.COLOR_BGR2HSV)

hist = cv2.calcHist( [hsv], [0, 1], None, [180, 256], [0, 180, 0, 256] )
print(hist)

gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
fm = variance_of_laplacian(gray)
if fm > 100:
	text = " - Not Blurry: "+str(fm)
	print(" - Not Blurry: "+str(fm))
 
# if the focus measure is less than the supplied threshold,
# then the image should be considered "blurry"
if fm < 100:
	text = " - Blurry: "+str(fm)
	print(" - Blurry: "+str(fm))

# show the image
cv2.putText(img, "{}: {:.2f}".format(text, fm), (10, 30),
cv2.FONT_HERSHEY_SIMPLEX, 0.8, (0, 0, 255), 3)
cv2.imshow("Image", img)
key = cv2.waitKey(0)
