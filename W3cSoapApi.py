import urllib2
from BeautifulSoup import BeautifulSoup

class W3cSoapApi:
  headers = dict()
  
  def __init__(self, url=""):
    self.url = url

  def setUrl(self):
    self.url = url

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

  def parse(self):
    w3curl = "http://validator.w3.org/check?uri="+self.url+"&output=soap12"
    req = urllib2.Request(w3curl, headers=self.headers)
    ret = urllib2.urlopen(req)
    self.resheads = ret.info()
    resdata = ret.read()
    
    self.soup = BeautifulSoup(resdata, convertEntities=BeautifulSoup.HTML_ENTITIES)
    