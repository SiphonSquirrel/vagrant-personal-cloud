#!/usr/bin/python

import sys, os, os.path
import urllib
import urllib2
import json

if len(sys.argv) == 1 or '/' not in sys.argv[1]:
    print "Please specify box in format user/boxname"
    sys.exit(1)

box = sys.argv[1]

version = None
if len(sys.argv) >= 3:
    version = sys.argv[2]

dest = os.getcwd()
if len(sys.argv) >= 4:
    dest = sys.argv[3]

if version == None:
    print "Downloading latest of " + box + " to " + dest
else:
    print "Downloading " + version + " of " + box + " to " + dest

response = urllib2.urlopen('https://atlas.hashicorp.com' + '/api/v1/box/' + box)
meta = json.loads(response.read())

versionMeta = None
if version == None:
    versionMeta = meta["current_version"]
else:
    versionList = []
    for candidate in meta["versions"]:
        if candidate["version"] == version:
            versionMeta = candidate
            break
        else:
            versionList.append(candidate["version"])
    if versionMeta == None:
        print "Cannot find version " + version + ", available: " + ", ".join(versionList)
        sys.exit(1)

baseDir = dest + "/" + box + "/" + versionMeta["version"]
if not os.path.isdir(baseDir):
    os.makedirs(baseDir)

boxMetaOut = {
    "description_markdown":meta["description_markdown"],
    "short_description":meta["short_description"]
}

with open(dest + "/" + box + "/meta.json", "w") as fp:
    json.dump(boxMetaOut, fp)

versionMetaOut = {
  "description_markdown":versionMeta["description_markdown"]
}

with open(baseDir + "/meta.json", "w") as fp:
    json.dump(versionMetaOut, fp)

for provider in versionMeta["providers"]:
    if not os.path.isdir(baseDir + "/" + provider["name"]):
        os.makedirs(baseDir + "/" + provider["name"])
    providerDest = baseDir + "/" + provider["name"] + "/package.box"
    if os.path.isfile(providerDest):
        print "Skipping provider download to " + providerDest + ", package exists."
    else:
        print "Downloading box for " + provider["name"] + " to " + providerDest
        urllib.urlretrieve(provider["download_url"], providerDest)
