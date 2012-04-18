# -*- coding: utf-8 -*-
import argparse
import sys
import time
import urllib2, urllib
import json
from urlparse import urlparse

import PageParser
import W3cSoapApi

def postResults(cburl, results):
  print "URL: "+cburl
  print json.dumps(results)
  """
  req = urllib2.Request(cburl, urllib.urlencode({"json-data": json.dumps(results)}) )
  req.add_header("Content-type", "application/x-www-form-urlencoded")
  res = urllib2.urlopen(req)
  print res.read()"""

def urlCheck(str):
  check = urlparse(str)
  #print check
  if check.netloc == '' or check.scheme == '':
    raise argparse.ArgumentTypeError('Rossz URL formátum! (A sémát is meg kell adni! http, https...)')
  return check.geturl()


def main():
  parser = argparse.ArgumentParser(description='Sitevalidator alkalmazas, weboldalak teljes validalasahoz.')
  parser.add_argument('--xml', action='store_true', help='Google sitemap használatához kapcsoló.')
  parser.add_argument('--format', choices=['silent', 'long'], default='long', help='A kimenet formázása.')
  parser.add_argument('--callback', help='Futtatás után ezt az oldalt hívja meg az eredményekkel.')
  parser.add_argument('url', metavar='URL', type=urlCheck, help='Validalni kívánt oldal URL címe.')
  
  #parser.print_help()
  args = parser.parse_args()
  #print args
  #print args.url
  results = []
  
  pp = PageParser.PageParser(args.url)
  if args.xml:
    pp.setXmlFormat(True) # ha XML kapcsolo is van, akkor ezt jelezzuk az URL gyujtonek
  pp.parsePage()
  
  #print pp.getLinks()
  
  
  if args.format == 'long':
    print "Talat linkek: "+str(len(pp.getLinks()))
    print pp.getLinks()
 
  val = W3cSoapApi.W3cSoapApi()

  for link in pp.getLinks():
    if link[0] == 200: #ha jo az url, csak akkor validaltatjuk
      val.setUrl(link[1])
      val.parseAll()
      if args.format == 'long':
        print "Page: ", val.getUrl()
        print "HTML: ", val.getDoctype()
        if not val.isValid():
          print "Error: ", val.getErrorNum()
          print "Warning: ", val.getWarningNum()
        else:
          print "Valid, doc: ", val.getDoctype()
        print "CSS: ", val.getCSSDoctype()
        if not val.isValidCSS():
          print "Error: ", val.getCSSErrorNum()
          print "Warning: ", val.getCSSWarningNum()
        else:
          print "Valid, doc: ", val.getCSSDoctype()
      
      if args.callback: # ha van callback, akkor kiszedjuk az eredmenyeket egy tombbe
        results.append({'code': link[0], 'url': val.getUrl(),
        'htmldoctype': val.getDoctype(), 'htmlvalidity': val.isValid(), 'htmlerrornum': val.getErrorNum(), 'htmlwarningnum': val.getWarningNum(),
        'cssdoctype': val.getCSSDoctype(), 'cssvalidity': val.isValidCSS(), 'csserrornum': val.getCSSErrorNum(), 'csswarningnum': val.getCSSWarningNum()})
        # URL, doctype, valid-e, error, warning, csstype, valid-e, error, warning
      #print "."
      time.sleep(1) #legalabb 1 sec kell
    
    else: #HA a link nem 200-as kodot adott vissza
      #print "Nem 200-as...."
      results.append({'code': link[0], 'url': link[1] })
      

  
  
  
  
  if args.callback:
    #print "Van callback: ",args.callback
    postResults(args.callback, results)
    
  
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
