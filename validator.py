import argparse, sys, urllib2
from BeautifulSoup import BeautifulSoup


def main():
  parser = argparse.ArgumentParser(description='Sitevalidator alkalmazas, weboldalak teljes validalasahoz.')
  parser.print_help()
  
  churl = "http://people.inf.elte.hu/vzoli" #web URL
  req = urllib2.Request("http://validator.w3.org/check?uri="+churl+"&output=soap12") #validation...
  r = urllib2.urlopen(req)
  headers = r.info() # -> headers['X-W3C-Validator-*']
  data = r.read()
  
  soup = BeautifulSoup(data, convertEntities=BeautifulSoup.HTML_ENTITIES)
  errors = soup.findAll('m:error')
  for error in errors:
    print 'Sor: ', error('m:line')[0].string
    print 'Oszlop: ', error('m:col')[0].string
    print 'Hiba: ', error('m:message')[0].string
    print "------------------------------"
  
  print 'DOCTYPE: ', soup.first('m:doctype').string #doctype
  print 'CHARSET: ', soup.first('m:charset').string #encoding
  print 'VALID: ',soup.first('m:validity').string #validity
  print 'ERRORS: ', soup.first('m:errorcount').string
  print 'WARNINGS: ', soup.first('m:warningcount').string

if __name__ == "__main__":
  sys.exit(main())
