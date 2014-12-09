def read_file():
	 f = open('NUTS', 'r')
	 f2 = open('region.sql','w')
	 c = 0
	 s = ""
	 for line in f:
	 	splited = line.split(';', 1 )
	 	if(c == 0):
	 		f2.write("INSERT INTO NUTS_D (nuts_III,concelho) values ('%s','%s')\n" % (splited[0],splited[1].rstrip()))
	 	if(c != 0):
	 		f2.write(",('%s','%s')\n" % (splited[0],splited[1].rstrip()))
	 	c += 1
read_file();