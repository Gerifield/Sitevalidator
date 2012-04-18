# -*- encoding: utf-8 -*-
from bs4 import BeautifulSoup
import urllib2
import sys
#import re
import urlparse

class CodeProfiler:
  url = ""
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
  
  
  def start(self):
    
    #try:
      html = urllib2.urlopen(self.url)
      print "URL:",html.geturl()
      print "Header:",html.info()
      print "TEST:",html.info().gettype()
      html = html.read()
      #soup = BeautifulSoup(html, convertEntities=BeautifulSoup.HTML_ENTITIES)
      soup = BeautifulSoup(html)
      #print html
      print soup.html
      open("dump.txt", "w").write(html)
      
      print "Karakterek:", len(html) #Content-Length is ennyi!
      self.htmlsize = len(html)
      self.fullhtmlsize = len(html)
      
      #CSS kereses:
      for elem in soup.find_all(style=True): #barmi ami style-t tartalmaz:
        print elem['style'] + " -> " + str(len(elem['style']))
        self.incsssize += len(elem['style'])
        #inline csss size
      for elem in soup.find_all("style"):
        print elem.string + " -> " + str(len(elem.string))
        self.incsssize += len(elem.string)
      
      #INLINE CSS-t kivonjuk a html méretből!
      self.htmlsize -= self.incsssize
      
      #kulso css meresek
      for elem in soup.find_all("link", type="text/css"):
        cssurl = urlparse.urljoin(self.url, elem['href'])
        print cssurl
        self.csssize += len(urllib2.urlopen(cssurl).read())
        self.csslinks.append(cssurl)
      
      
      
      #JS kereses:
      for elem in soup.find_all("script", type="text/javascript"):
        #if hasattr(elem, 'string'): #lehet üres is!
        if elem.string:
          print elem.string + " -> " + str(len(elem.string))
          self.injssize += len(elem.string)
      #INLINE JS-t kivonjuk a html méretből!
      self.htmlsize -= self.injssize
      
      #kulso js meresek
      for elem in soup.find_all("script", type="text/javascript", src=True):
        print elem['src']
        jsurl = urlparse.urljoin(self.url, elem['src'])
        print jsurl
        self.jssize += len(urllib2.urlopen(jsurl).read())
        self.jslinks.append(jsurl)
        
        
      #IMG tag szamolas:  
      for elem in soup.find_all('img', src=True): #biztos legyen src is
        imgurl = urlparse.urljoin(self.url, elem['src'])
        self.imgtagnum += 1
        self.imglinks.append(imgurl)
        
        
      print "HTML:", self.htmlsize
      print "inCSS:", self.incsssize
      print "inJS:", self.injssize
      print "CHECK:"
      print "FULL:", self.fullhtmlsize
      print "SUM:", self.htmlsize+self.incsssize+self.injssize
      print ""
      print "Kulso CSS:", self.csssize
      print "Kulso JS:", self.jssize
      print ""
      print "Kepek: ", self.imgtagnum
      print "\n"
      print "CSS:", self.csslinks
      print "JS:", self.jslinks
      print "IMG:", self.imglinks
      
      
    #except:
    #  print "Error..."
      
cp = CodeProfiler("http://gerifield.hu")
cp.start()