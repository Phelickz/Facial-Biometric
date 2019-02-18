#!/usr/bin/python
import sys
sys.path.insert(0, '/usr/bin/python2.7')

from wsgiref.handlers import CGIHandler
from hello import app

CGIHandler().run(app)