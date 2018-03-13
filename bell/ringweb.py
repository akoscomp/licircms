from time import sleep
import pifacedigitalio
import sys

p = pifacedigitalio.PiFaceDigital()

if sys.argv[1] == "Start":
    p.leds[0].turn_on()
    p.leds[1].turn_on()
else:
    p.output_port.all_off()

print p.output_pins[1].value
#print sys.argv[1]
