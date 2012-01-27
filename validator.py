import argparse, sys, urllib2
from BeautifulSoup import BeautifulSoup


def main():
  parser = argparse.ArgumentParser(description='Sitevalidator alkalmazas, weboldalak teljes validalasahoz.')
  parser.print_help()
  
  churl = "http://people.inf.elte.hu/vzoli" #web URL
  req = urllib2.Request("http://validator.w3.org/check?uri="+churl+"&output=soap12") #validation...
  r = urllib2.urlopen(req)
  headers = r.info() # -> headers['X-W3C-Validator-*']
  data = r.read()
  


if __name__ == "__main__":
  sys.exit(main())
