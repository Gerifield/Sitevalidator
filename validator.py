# -*- coding: utf-8 -*-
import argparse
import sys
import W3cSoapApi



def main():
  parser = argparse.ArgumentParser(description='Sitevalidator alkalmazas, weboldalak teljes validalasahoz.')
  parser.add_argument('--xml', metavar='', help='Google sitemap haszn�lat�hoz kapcsol�.')
  parser.add_argument('--format', choices=['short', 'long'], default='long', help='A kimenet form�z�sa.')
  parser.add_argument('url', metavar='URL', help='Validalni kivant oldal URL cime')
  parser.print_help()
  
  #churl = "http://people.inf.elte.hu/vzoli" #web URL
  #req = urllib2.Request("http://validator.w3.org/check?uri="+churl+"&output=soap12") #validation...
  #r = urllib2.urlopen(req)
  #headers = r.info() # -> headers['X-W3C-Validator-*']
  #data = r.read()
  
  #soup = BeautifulSoup(data, convertEntities=BeautifulSoup.HTML_ENTITIES)
  #errors = soup.findAll('m:error')
  #for error in errors:
  #  print 'Sor: ', error('m:line')[0].string
  #  print 'Oszlop: ', error('m:col')[0].string
  #  print 'Hiba: ', error('m:message')[0].string
  #  print "------------------------------"
  
  #print 'DOCTYPE: ', soup.first('m:doctype').string #doctype
  #print 'CHARSET: ', soup.first('m:charset').string #encoding
  #print 'VALID: ',soup.first('m:validity').string #validity
  #print 'ERRORS: ', soup.first('m:errorcount').string
  #print 'WARNINGS: ', soup.first('m:warningcount').string
  
  #validator = W3cSoapApi.W3cSoapApi(churl)
  #validator.parse()
  #validator.parseCSS()
  
  #validator.parseAll()
  #print validator.getHeaders()
  #print "------------------"
  #print "Doctype: ", validator.getDoctype()
  #print "Errors: ", validator.getErrorNum()
  #print "Warnings: ", validator.getWarningNum()
  #print "Valid? ", validator.isValid()
  #print ""
  #print "------------------------"
  #print ""
  
  #print validator.getCSSHeaders()
  #print "------------------"
  #print "Doctype: ", validator.getCSSDoctype()
  #print "Errors: ", validator.getCSSErrorNum()
  #print "Warnings: ", validator.getCSSWarningNum()
  #print "Valid? ", validator.isValidCSS()
  

if __name__ == "__main__":
  sys.exit(main())
