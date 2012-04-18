# -*- encoding: utf-8 -*-
from bs4 import BeautifulSoup
import urllib2
import sys
#import re
import urlparse

class CodeProfiler:
  url = ""
  urlcode = -1
  fullhtmlsize = 0
  htmlsize = 0
  incsssize = 0
  csssize = 0
  csslinks = []
  
  injssize = 0
  jssize = 0
  jslinks = []
  
  imgtagnum = 0
  imglinks = []
  
  def __init__(self, url):
    self.url = url
    
  def getURL(self):
    return [self.urlcode, self.url]
  
  def getFullHTMLSize(self): #teljes html oldal merete
    return self.fullhtmlsize
  
  def getHTMLSize(self): #oldal meret minusz inline html es js kodok
    return self.htmlsize
  
  def getInCSSSize(self): #inline css kod
    return self.incsssize
  
  def getCSSSize(self):   #kulso css-ek merete
    return self.csssize
  
  def getAllCSSsize(self):  #osszes css meret
    return self.csssize + self.incsssize
   
  def getCSSLinks(self): #css linkek
    return self.csslinks
  
  def getInJSSize(self): #inline javascript meret
    return self.injssize
    
  def getJSSize(self): #kulso js meretek
    return self.jssize
  
  def getAllJSSize(self): #teljes js meret
    return self.injssize + self.jssize
    
  def getJSLinks(self): #js linkek
    return self.jslinks
    
  def getIMGNum(self): #linkelt kepek (<img> tegek szama)
    return self.imgtagnum
    
  def getIMGLinks(self): #keplinkek
    return self.imglinks
    
    
    
  
  def start(self):
    
    try:
      html = urllib2.urlopen(self.url)
      #print "URL:",html.geturl()
      self.url = html.geturl() #az atiranyitasokat is koveti
      
      #print "Header:",html.info()
      #print "TEST:",html.info().gettype()
      html = html.read()
      #soup = BeautifulSoup(html, convertEntities=BeautifulSoup.HTML_ENTITIES)
      soup = BeautifulSoup(html)
      #print html
      #print soup.html
      open("dump.txt", "w").write(html)
      
      #print "Karakterek:", len(html) #Content-Length is ennyi!
      self.htmlsize = len(html)
      self.fullhtmlsize = len(html)
      
      #CSS kereses:
      for elem in soup.find_all(style=True): #barmi ami style-t tartalmaz:
        #print elem['style'] + " -> " + str(len(elem['style']))
        self.incsssize += len(elem['style'])
        #inline csss size
      for elem in soup.find_all("style"):
        #print elem.string + " -> " + str(len(elem.string))
        self.incsssize += len(elem.string)
      
      #INLINE CSS-t kivonjuk a html méretből!
      self.htmlsize -= self.incsssize
      
      #kulso css meresek
      for elem in soup.find_all("link", type="text/css"):
        cssurl = urlparse.urljoin(self.url, elem['href'])
        #print cssurl
        try:
          self.csssize += len(urllib2.urlopen(cssurl).read())
        except urllib2.URLError, ex: #valamilyen hiba
          if hasattr(ex, 'reason'): #kapcsolodasi
            self.csslinks.append([ -1, cssurl])
          elif hasattr(ex, 'code'): #webszerver hiba
            self.csslinks.append([ ex.code, cssurl])
        else: #minden ok
          self.csslinks.append([ 0, cssurl])
      
      
      
      #JS kereses:
      for elem in soup.find_all("script", type="text/javascript"):
        #if hasattr(elem, 'string'): #lehet üres is!
        if elem.string:
          #print elem.string + " -> " + str(len(elem.string))
          self.injssize += len(elem.string)
      #INLINE JS-t kivonjuk a html méretből!
      self.htmlsize -= self.injssize
      
      #kulso js meresek
      for elem in soup.find_all("script", type="text/javascript", src=True):
        #print elem['src']
        jsurl = urlparse.urljoin(self.url, elem['src'])
        #print jsurl
        try:
          self.jssize += len(urllib2.urlopen(jsurl).read())
        except urllib2.URLError, ex:
          if hasattr(ex, 'reason'):
            self.jslinks.append([ -1, jsurl])
          elif hasattr(ex, 'code'):
            self.jslinks.append([ ex.code, jsurl])
        else:
          self.jslinks.append([ 0, jsurl])
        
        
      #IMG tag szamolas:  
      for elem in soup.find_all('img', src=True): #biztos legyen src is
        imgurl = urlparse.urljoin(self.url, elem['src'])
        self.imgtagnum += 1
        self.imglinks.append(imgurl)

      
      
    except urllib2.URLError, e:
      if hasattr(e, 'reason'):
        #print 'Reason: ', e.reason
        self.urlcode = -1
      elif hasattr(e, 'code'):
        #print 'Error code: ', e.code
        self.urlcode = e.code
    else:
      self.urlcode = 0




cp = CodeProfiler("http://gerifield.hu/")
cp.start()


print "HTML:", cp.getHTMLSize()
print "inCSS:", cp.getInCSSSize()
print "inJS:", cp.getInJSSize()
print "CHECK:"
print "FULL:", cp.getFullHTMLSize()
#print "SUM:", self.htmlsize+self.incsssize+self.injssize
print ""
print "Kulso CSS:", cp.getCSSSize()
print "Kulso JS:", cp.getJSSize()
print ""
print "Kepek: ", cp.getIMGNum()
print "\n"
print "CSS:", cp.getCSSLinks()
print "JS:", cp.getJSLinks()
print "IMG:", cp.getIMGLinks()
print "URL:", cp.getURL()
