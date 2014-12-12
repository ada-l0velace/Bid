SELECT 
    (CASE
        WHEN t.concelho IS NULL THEN 'Grand Total'
        WHEN (t.year IS NULL AND t.month IS NULL AND t.concelho IS NOT NULL) THEN 'Total Years' 
        WHEN t.month IS NULL THEN 'Total Year'
        ELSE 'Total Month'
    END) AS Totals,
    t.concelho AS concelho,
    t.month AS Month,
    t.year AS Year,
    t.sum_lance
FROM
    (SELECT 
        NUTS_D.concelho,
            Dates_D.year,
            Dates_D.month,
            SUM(tblfacts.max_lance) AS sum_lance
    FROM
        tblfacts, Dates_D, NUTS_D
    WHERE
        tblfacts.data_id = Dates_D.date_id
            AND tblfacts.region_id = NUTS_D.region_id
            AND Dates_D.year >= 2012
            AND Dates_D.year <= 2013
    GROUP BY NUTS_D.concelho , Dates_D.year , Dates_D.month WITH ROLLUP) AS t
