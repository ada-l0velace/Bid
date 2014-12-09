import random

def read_file():
	f = open('names', 'r')
	f2= open('pessoas', 'w')
	print "a"
	first_name = []
	second_name = []
	nif = []
	fez = 0
	counter = 0
	s = ""
	for line in f:
			splited = line.split(',', 1)
			first_name.append(splited[0])

			second_name.append(splited[1].rstrip())
	
	while (counter < 100010):
		
		pin = random.randint(1000,9999)
		counter += 1
		f2.write("('%d','%s %s','%d'),\n" % (counter, random.choice(first_name), random.choice(second_name), pin))


read_file();