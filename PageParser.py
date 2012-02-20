import urllib2
from BeautifulSoup import BeautifulSoup
from urlparse import urlparse

class PageParser:
  urllist = []
  finurl = []
  baseurl = ""
  
  def __init__(self, url):
    self.addUlr(url)
    url = urlparse(url)
    self.baseurl = url.netloc #kiszedjuk az url cimet
  
  def addUlr(self, url):
    if self.finurl.count(url) == 0: #ha eddig nem dolgoztuk mar fel
      self.urllist.append(url)

  def isUrl(self):
    return len(self.urllist) > 0
  def nextUrl(self):
    ret = self.urllist.pop()
    self.finurl.append(ret) #hozzaadjuk a feldolgozotthoz
    return ret
  def isLocal(self, url):
    url = urlparse(url)
    if self.baseurl == url.netloc:
      return True
    else:
      return False
  def parsePage(self):
    if self.isUrl():
      u = self.nextUrl()
      html = urllib2.urlopen(u).read()
      soup = BeautifulSoup(html, convertEntities=BeautifulSoup.HTML_ENTITIES)
      
      print soup.findAll('a')
      
    else:
      return False