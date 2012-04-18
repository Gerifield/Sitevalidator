import urllib2
import re
from BeautifulSoup import BeautifulSoup
import urlparse

class PageParser:
  urllist = []
  finurl = []
  baseurl = ""
  latesturl = ""
  allowedEnds = [".php", ".htm", ".html", ".asp"] #Gond, ha nincs semmilyen vegzodes!
  # /-t kivettem, azzal ovatosan!
  aloldal = 0
  error = False
  errormsg = ""
  xmlFormat = False
  
  def setXmlFormat(self, val):
    self.xmlFormat = val
  
  def __init__(self, url):
    if url.endswith("/") or not self.checkEnding(url):
      self.errormsg = "Teljes URL-t kell megadni!"
      self.error = True
    else:
      self.latesturl = url
      self.addUrl(url)
      url = urlparse.urlparse(url)
      self.baseurl = url.scheme + "://" + url.netloc #kiszedjuk az url cimet
  
  def isUnknown(self, url): #ellenorizzuk, hogy mar ismert-e
    for c, u in self.finurl:
      if u == url:
        return False
    for c, u in self.urllist:
      if u == url:
        return False
    return True
  
  def addUrl(self, url):
    if not url.startswith("http"):
      #print "MURL: ", url
      url = urlparse.urljoin(self.latesturl, url) #Extrem esetben hibas lehet!
      #print "Mod: "+url
    #if self.finurl.count(url) == 0 and self.urllist.count(url) == 0: #ha eddig nem dolgoztuk fel es nincs a varakozok kozott sem
    if self.isUnknown(url):
      self.urllist.append([0, url])
      self.aloldal += 1
      #print "Added! Num: ", self.aloldal, url
    
  def hasUrl(self):
    return len(self.urllist) > 0
    
  def nextUrl(self):
    ret = self.urllist.pop()
    self.finurl.append(ret) #hozzaadjuk a feldolgozotthoz
    return ret
    
  def isLocal(self, url):
    url = urlparse.urlparse(url)
    if self.baseurl == url.scheme + "://" + url.netloc:
      return True
    else:
      return False

  def checkEnding(self, url):
    for end in self.allowedEnds:
      if url.endswith(end):
        #print url
        return True
    return False

  def getEndings(self):
    return self.allowedEnds
  
  def addEnding(self, end):
    self.allowedEnds.append(end) #.valami formaban
  
  def getLinks(self):
    return self.finurl
  
  def parsePage(self): # minden aloldalon vegigmegy
    if self.error:
      print self.errormsg
      return False

    while self.hasUrl():
      url = self.nextUrl()
      u = url[1] #az url cimet kiszedjuk
      try:
        resp = urllib2.urlopen(u)
        url[0] = resp.getcode()
        html = resp.read()
        #print "          U: "+u
        self.latesturl = u #eltaroljuk, hogy az almappakra is jo legyen
        soup = BeautifulSoup(html, convertEntities=BeautifulSoup.HTML_ENTITIES)
        #print html
        
        
        #TODO: "Inline" CSS es Javascript kodokat lekezelni!
        if self.xmlFormat:
          tags = soup.findAll('a') #ha xml-t kap, batran szedhet minden a tagot ki belole
        else:
          tags = soup.findAll('a', attrs={'href': re.compile("^"+self.baseurl+"|^(?!http|javascript)")}) #csak a lokalis url-eket szedjuk ki
        #REGEX: sajat "baseurl" VAGY nem http/javascript kezdet
        for tag in tags:
          if tag.has_key('href'):
            #print tag #URL feldolgozas
            if self.checkEnding(tag['href']):
              #print "Good: "+tag['href']
              self.addUrl(tag['href'])
      except urllib2.URLError, e: #URL hibak kezelese
        if hasattr(e, 'reason'):
          #print 'Reason: ', e.reason
          url[0] = -1
        elif hasattr(e, 'code'):
          #print 'Error code: ', e.code
          url[0] = e.code
    #else:
      #print "URL lista: ", self.urllist
      #print "URL lista: ", self.aloldal
      #print "Volt: ", len(self.finurl)
      #return True