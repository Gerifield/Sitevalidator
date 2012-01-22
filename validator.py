import argparse, sys, httplib


def main():
  parser = argparse.ArgumentParser(description='Sitevalidator alkalmazas, weboldalak teljes validalasahoz.')
  parser.print_help()
  churl = "http://people.inf.elte.hu/vzoli"
  conn = httplib.HTTPConnection("validator.w3.org")
  conn.request("GET", "/check?uri="+churl+"&output=soap12")
  resp = conn.getresponse()

  print resp.getheaders()


if __name__ == "__main__":
  sys.exit(main())
