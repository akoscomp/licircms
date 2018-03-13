#!/usr/bin/env python

import time
from time import sleep
import pifacedigitalio
import sys
import datetime
import subprocess

if len(sys.argv) < 2:
    sys.stderr.write('Error: no argument')
    sys.exit(1)

raw = subprocess.check_output(['awk', '{print $1}', '/proc/uptime'])
uptime = 0 + float(raw)
print 'System uptime of %d seconds' % (uptime)

localtime = time.strftime('%Y-%m-%d %H:%M:%S')

year = datetime.date.today().year
p = pifacedigitalio.PiFaceDigital()

if (year > 2016) and (uptime > 300):
  print localtime, "- Ring start:", sys.argv[1]

  p.leds[0].turn_on()
  p.leds[1].turn_on()
  sleep(int(sys.argv[1]))
  p.output_port.all_off()

  print localtime, " - Ring stop."
else:
  print localtime, "Date or uptime (" + str(uptime) + ") error."
  p.output_port.all_off()

