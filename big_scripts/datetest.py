import datetime
def test():
	base = datetime.datetime(2012, 1, 1, 0, 0, 0)
	date_list = [base + datetime.timedelta(days=x) for x in range(0, 730)]
	print datetime.datetime.now() < date_list[0]
	print datetime.datetime.now()
	print date_list[0]
	print str(date_list[0].date())
test()