# source: http://snipplr.com/view.php?codeview&id=55913 as basis for loading
# source: http://www.nyc.gov/html/doh/downloads/pdf/rii/how-we-score-grade.pdf shows that lower scores are better

# This file loads in the restaurant rating data based on MySQL credentials, a csv file and a mapping file
# I would normally add a file for logging errors and a check for duplicates if data was to be loaded on a scheduled basis
import sys
import MySQLdb
import csv
import datetime

def main(host, user, passwd, db, table, csvfile, mapfile):

    try:
        print 'connecting...'
        conn = getConn(host, user, passwd, db)
        print 'connected'
    except MySQLdb.Error, e:
        print "Error %d: %s" % (e.args[0], e.args[1])
        sys.exit (1)
    
    cursor = conn.cursor()

    print 'loading...'
    
    loadCSV(cursor, table, csvfile, mapfile)
    conn.commit()
    cursor.close()
    conn.close()

    print 'loaded'

def getConn(host, user, passwd, db):
    conn = MySQLdb.connect(host = host,
                           user = user,
                           passwd = passwd,
                           db = db)
    return conn

# transform the data to work with db
def cleanLine(line,types):

    # convert dates and remove special characters
    def cleanItem(ind,x):
        date_cols = []
        for i,col in enumerate(types):
            if col == "date":
                date_cols.append(i)

        if ind in date_cols:
            if x is not "":
                x = datetime.datetime.strptime(x, '%m/%d/%Y').strftime('%Y-%m-%d')
        if(x == ""):
            return None
        else:
            return ''.join([i if ord(i) < 128 else ' ' for i in x])
        
    return [cleanItem(ind,x) for ind,x in enumerate(line)]

# read the file line by line and insert the data
def loadCSV(cursor, table, filename, mapfile):

    #create dictionary from mapping file
    col_map = csv.reader(open(mapfile))
    type_map = csv.reader(open(mapfile))
    #first cole of mapfile is file col, second is db col, third is data type
    map_dict = {rows[0]:rows[1] for rows in col_map}
    type_dict = {rows[0]:rows[2] for rows in type_map}

    file_reader = csv.reader(open(filename))
    
    header = file_reader.next()
    numfields = len(header)

    values = []
    types = []
    #create column list in-order using mapping
    for col in header:
        col_val = map_dict[col]
        col_type = type_dict[col]

        values.append(col_val)
        types.append(col_type)

    query = buildInsertSQL(table, numfields, values)

    rows_inserted = 0
    for line in file_reader:
        vals = cleanLine(line,types)
        cursor.execute(query, vals)
        rows_inserted += 1
    print 'inserted ' + str(rows_inserted) + ' rows'

    return

# build each insert query
def buildInsertSQL(table, numfields, values):

    assert(numfields > 0)
    placeholders = (numfields-1) * "%s, " + "%s"
    query = ("insert into %s" % table) + ("("+",".join(values)+") values (%s)" % placeholders)

    return query

if __name__ == '__main__':

    args = sys.argv[1:]
    if(len(args) < 7):
        print "error: arguments: host user passwd db table csvfile mapfile"
        sys.exit(1)

    main(*args)