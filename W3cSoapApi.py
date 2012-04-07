import urllib2
from BeautifulSoup import BeautifulSoup

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
      return self.soup.first('m:doctype').string
    except:
      return "Error"

  def getCharset(self):
    try:
      return self.soup.first('m:charset').string
    except:
      return "Error"

  def isValid(self):
    try:
      if self.soup.first('m:validity').string == "true":
        return True
      else:
        return False
    except:
      return False

  def getErrorNum(self):
    try:
      return self.soup.first('m:errorcount').string
    except:
      return -1
  def getWarningNum(self):
    try:
      return self.soup.first('m:warningcount').string
    except:
      return -1


  def getCSSHeaders(self):
    try:
      return self.cssresheads
    except:
      return dict() #empty dictionary

  def getCSSDoctype(self):
    try:
      return self.csssoup.first('m:csslevel').string
    except:
      return "Error"

  def getCSSCharset(self):
    try:
      return self.csssoup.first('m:charset').string
    except:
      return "Error"

  def isValidCSS(self):
    try:
      if self.csssoup.first('m:validity').string == "true":
        return True
      else:
        return False
    except:
      return False

  def getCSSErrorNum(self):
    try:
      return self.csssoup.first('m:errorcount').string
    except:
      return -1
  def getCSSWarningNum(self):
    try:
      return self.csssoup.first('m:warningcount').string
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
    
    self.soup = BeautifulSoup(resdata, convertEntities=BeautifulSoup.HTML_ENTITIES)
    
  def parseCSS(self):
    w3curl = "http://jigsaw.w3.org/css-validator/validator?uri="+self.url+"&output=soap12"
    req = urllib2.Request(w3curl, headers=self.headers)
    ret = urllib2.urlopen(req)
    self.cssresheads = ret.info()
    resdata = ret.read()
    print "\n\n"
    print resdata
    print "\n\n"
    
    self.csssoup = BeautifulSoup(resdata, convertEntities=BeautifulSoup.HTML_ENTITIES)
    