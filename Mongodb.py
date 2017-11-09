from pymongo import MongoClient
Client=MongoClient()
db= Client["sth"]
collection=db["stha"]