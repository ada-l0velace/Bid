import random
import datetime
def read_file():
	f2 = open('leilao.sql', 'w')
	f3 = open('leilaor.sql', 'w')
	f4 = open('concorrente.sql', 'w')
	f5 = open('lance.sql', 'w')
	material = ['Metal','Madeira','Cobre','Cristal','Marmore','Gas','Lapis','Chumbo']
	n_pessoas = 3
	n_leil = 20010
	contador_datas=0
	counter = 0 #nif
	contador2 = 0 #lid
	alvara = 600
	day = 1
	base = datetime.datetime(2012, 1, 1, 0, 0, 0)
	date_list = [base + datetime.timedelta(days=x) for x in range(0, 731)]
	dias = len(date_list)
	f2.write("INSERT into leilao VALUES \n")
	f3.write("INSERT into leilaor VALUES \n")
	f4.write("INSERT into concorrente VALUES \n")
	f5.write("INSERT into lance VALUES \n")
	year = 0
	while (day < dias):
		counter = 1
		while (counter < 50):
			contador = 1
			while (contador <= 2):
				indicematerial=random.randint(0, 7)
				valorbase = random.randint(400,900)
				f2.write("('%s', '%d', '%d', '%s', '%d', '1'),\n" % (str(date_list[day].date()), contador, counter, material[indicematerial], valorbase))
				contador2+=1
				ndiasaberto = random.randint(0, 31)
				f3.write("('%s', '%d', '%d', '%s', '%d'),\n" % (str(date_list[day].date()), contador, counter,ndiasaberto, contador2))
				contador+=1
				valor = random.randint(901,2000)
				for i in range(50000,n_pessoas+50000):
					f4.write("('%d', '%d'),\n" % (i, contador2))
					f5.write("('%d', '%d', '%d'),\n" % (i, contador2,valor))
					valor += random.randint(1, 100)
			counter+=1
		day+=1
read_file()