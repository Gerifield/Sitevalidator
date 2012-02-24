import urllib2
import re
from BeautifulSoup import BeautifulSoup
import urlparse

class PageParser:
  urllist = []
  finurl = []
  baseurl = ""
  firsturl = ""
  allowedEnds = ["/", ".php", ".htm", ".html", ".asp"]
  aloldal = 0
  
  
  def __init__(self, url):
    self.firsturl = url
    self.addUrl(url)
    url = urlparse.urlparse(url)
    self.baseurl = url.scheme + "://" + url.netloc #kiszedjuk az url cimet
    print self.baseurl
  
  def addUrl(self, url):
    if not url.startswith("http"):
      url = urlparse.urljoin(self.firsturl, url)
      print "Mod: "+url
    if self.finurl.count(url) == 0 and self.urllist.count(url) == 0: #ha eddig nem dolgoztuk fel es nincs a varakozok kozott sem
      self.urllist.append(url)
      self.aloldal += 1
      print "Added! Num: ", self.aloldal

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
    while self.hasUrl():
      u = self.nextUrl()
      #try:
      html = urllib2.urlopen(u).read()
      soup = BeautifulSoup(html, convertEntities=BeautifulSoup.HTML_ENTITIES)
      #print html
        
      tags = soup.findAll('a', attrs={'href': re.compile("^"+self.baseurl+"|^(?!http|javascript)")}) #csak a lokalis url-eket szedjuk ki
      #REGEX: sajat "baseurl" VAGY nem http/javascript kezdet
      for tag in tags:
        if tag.has_key('href'):
          #print tag #URL feldolgozas
          if self.checkEnding(tag['href']):
            print "Good: "+tag['href']
            self.addUrl(tag['href'])
    #  except:
    #    print "Error: "+u # 404 lekezelese
    #else:
      #print "URL lista: ", self.urllist
      #print "URL lista: ", self.aloldal
      #print "Volt: ", len(self.finurl)
    #  return True