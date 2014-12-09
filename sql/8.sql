SELECT (case when t.concelho is null then 'Grand Total'
		when t.month is null then 'Total Year'
		else 'Total Month' 
		end) as Totals,
		t.concelho as concelho,
		t.month as Month ,
		t.year  as Year ,
		t.sum_lance 
FROM
 (SELECT NUTS_D.concelho,Dates_D.year, Dates_D.month, Sum(tblfacts.max_lance) as sum_lance
	FROM tblfacts,Dates_D,NUTS_D
	WHERE  tblfacts.data_id = Dates_D.date_id
	AND tblfacts.region_id = NUTS_D.region_id
	AND Dates_D.year >= 2012
	AND Dates_D.year <= 2013
	GROUP BY NUTS_D.concelho,Dates_D.year,Dates_D.month WITH ROLLUP) as t
WHERE t.month IS NOT  NULL
            OR t.year IS NOT NULL OR t.concelho IS NULL