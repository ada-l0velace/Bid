import random

def read_file():
	f = open('NUTS', 'r')
	f2= open('leiloeirasc', 'w')
	regiao = []
	concelho = []
	counter = 0 #nif
	alvara = 600
	s = ""
	linhas = len(f.readlines())
	f3 = open('NUTS', 'r')
	for line in f3:
		splited = line.split(';', 1)
		regiao.append(splited[0])
		print "a"
		print splited[0]
		print "b"

		concelho.append(splited[1].rstrip())
		print splited[1]
	
	while (counter < 10010):

		indicelinha = random.randint(0, linhas-1)
		print indicelinha
		print len(regiao)
		print len(concelho)
		regiaoescolhida = regiao[indicelinha]
		concelhoescolhido = concelho[indicelinha]

		counter += 1
		f2.write("('%d', '%d', '%s', '%s'),\n" % (counter, alvara, concelhoescolhido, regiaoescolhida))
		alvara += 1

read_file();