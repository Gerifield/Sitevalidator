import urllib2
import re
from BeautifulSoup import BeautifulSoup
from urlparse import urlparse

class PageParser:
  urllist = []
  finurl = []
  baseurl = ""
  
  def __init__(self, url):
    self.addUlr(url)
    url = urlparse(url)
    self.baseurl = url.scheme + "://" + url.netloc #kiszedjuk az url cimet
    #print self.baseurl
  
  def addUlr(self, url):
    if self.finurl.count(url) == 0: #ha eddig nem dolgoztuk mar fel
      self.urllist.append(url)

  def hasUrl(self):
    return len(self.urllist) > 0
  def nextUrl(self):
    ret = self.urllist.pop()
    self.finurl.append(ret) #hozzaadjuk a feldolgozotthoz
    return ret
  def isLocal(self, url):
    url = urlparse(url)
    if self.baseurl == url.scheme + "://" + url.netloc:
      return True
    else:
      return False
  def parsePage(self): # minden aloldalon vegigmegy
    while self.hasUrl():
      u = self.nextUrl()
      html = urllib2.urlopen(u).read()
      soup = BeautifulSoup(html, convertEntities=BeautifulSoup.HTML_ENTITIES)
      
      tags = soup.findAll('a', attrs={'href': re.compile("^"+self.baseurl)}) #csak a lokalis url-eket szedjuk ki
      for tag in tags:
        print tag['href'] #URL feldolgozas
      
    else:
      return True