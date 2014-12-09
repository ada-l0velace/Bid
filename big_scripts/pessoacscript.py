import random

def read_file():
	f2= open('pessoac', 'w')
	counter = 0
	s = ""
	
	#while (counter < 100010):
	while (counter < 30010):
		
		capital = random.randint(100000,999999)
		counter += 1
		f2.write("('%d','%d'),\n" % (counter, capital))


read_file();