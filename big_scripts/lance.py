import random

def read_file():
	f2 = open('concorrente.sql', 'w')
	f3 = open('lance.sql', 'w')
	n_leil = 20010
	n_pessoas = 5
	valor = 10

	for i in range(50000,n_pessoas+50000):
		for j in range(1,n_leil):
			f2.write("('%d', '%d'),\n" % (i, j))
			f3.write("('%d', '%d', '%d'),\n" % (i, j,valor))
		valor += 10


read_file();