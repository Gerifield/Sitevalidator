import urllib2
from bs4 import BeautifulSoup

class W3cSoapApi:
  headers = dict()
  
  def __init__(self, url=""):
    self.url = url

  def setUrl(self, url):
    self.url = url
  def getUrl(self):
    return self.url

  def addHeader(self, header, value):
    self.headers[header] = value

  def getHeader(self, header):
    if self.resheads.count(header) > 0:
      return self.resheads[header]
    else:
      return ""

  def getHeaders(self):
    try:
      return self.resheads
    except:
      return dict() #empty dictionary

  def getDoctype(self):
    try:
      return self.soup.find('m:doctype').string
    except:
      return "Error"

  def getCharset(self):
    try:
      return self.soup.find('m:charset').string
    except:
      return "Error"

  def isValid(self):
    try:
      if self.soup.find('m:validity').string == "true":
        return True
      else:
        return False
    except:
      return False

  def getErrorNum(self):
    try:
      return self.soup.find('m:errorcount').string
    except:
      return -1
  def getWarningNum(self):
    try:
      return self.soup.find('m:warningcount').string
    except:
      return -1


  def getCSSHeaders(self):
    try:
      return self.cssresheads
    except:
      return dict() #empty dictionary

  def getCSSDoctype(self):
    try:
      return self.csssoup.find('m:csslevel').string
    except:
      return "Error"


  def isValidCSS(self):
    try:
      if self.csssoup.find('m:validity').string == "true":
        return True
      else:
        return False
    except:
      return False

  def getCSSErrorNum(self):
    try:
      return self.csssoup.find('m:errorcount').string
    except:
      return -1
  def getCSSWarningNum(self):
    try:
      return self.csssoup.find('m:warningcount').string
    except:
      return -1

  def parseAll(self):
    self.parse()
    self.parseCSS()

  def parse(self):
    w3curl = "http://validator.w3.org/check?uri="+self.url+"&output=soap12"
    req = urllib2.Request(w3curl, headers=self.headers)
    ret = urllib2.urlopen(req)
    self.resheads = ret.info()
    resdata = ret.read()
    
    self.soup = BeautifulSoup(resdata)
    
  def parseCSS(self):
    w3curl = "http://jigsaw.w3.org/css-validator/validator?uri="+self.url+"&output=soap12"
    req = urllib2.Request(w3curl, headers=self.headers)
    ret = urllib2.urlopen(req)
    self.cssresheads = ret.info()
    resdata = ret.read()
    
    self.csssoup = BeautifulSoup(resdata)
    