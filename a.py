import json
import sys
import subprocess
from TwitterSearch import *
from tweepy import StreamListener
try:
              tso = TwitterSearchOrder() # create a TwitterSearchOrder object
              tso.set_keywords(['dell']) # let's define all words we would like to have a look for
              tso.set_language('en') # we want to see english tweets only
              tso.set_include_entities(False) # and don't give us all those entity information
              # it's about time to create a TwitterSearch object with our secret tokens
              ts = TwitterSearch(
                  consumer_key = 'J55i2ZajTUrbyMTJHIaBFmn4C',
                  consumer_secret = 'djuBIx5QfHRtGkvrGsRLGoGWuk2DJgpXUr3LeASYL3rfwupZQR',
                  access_token = '2419874802-BGudGB6uBs5Ehiym2tDgI4CGTpLgq7JcGNWHgAG',
                  access_token_secret = 'YpXfNHBqQKaI0h1MfzlvYwGeokHIZArYtQC1kfpc6JsIK'
                    )

              # this is where the fun actually starts :)

              from pymongo import MongoClient
              Client=MongoClient()
              db= Client["x"]
              collection=db["z"]
              count = 0
              for a in ts.search_tweets_iterable(tso):
               #print(a)
               collection.insert(a)
               if count>=25:
                 break


except TwitterSearchException as e: # take care of all those ugly errors if there are some
   print(e)
#subprocess.Popen("")
