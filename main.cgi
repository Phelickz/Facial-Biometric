#!/usr/bin/python36

from wsgiref.handlers import CGIHandler
from face import app

CGIHandler().run(app)