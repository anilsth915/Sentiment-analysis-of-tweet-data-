import csv
import pickle
import re

from bson import ObjectId

f = open('my_classifier.pickle', 'rb')
NBClassifier = pickle.load(f)
f.close()

inpTweets = csv.reader(open('dataset.csv', 'r'), delimiter=',', quotechar='|')


def processTweet(tweet):
    #Convert to lower case
    tweet = tweet.lower()
    #Convert www.* or https?://* to URL
    tweet = re.sub('((www\.[^\s]+)|(https?://[^\s]+))','URL',tweet)
    #Convert @username to AT_USER
    tweet = re.sub('@[^\s]+','AT_USER',tweet)
    #Remove additional white spaces
    tweet = re.sub('[\s]+', ' ', tweet)
    #Replace #word with word
    tweet = re.sub(r'#([^\s]+)', r'\1', tweet)
    #trim
    tweet = tweet.strip('\'"')
    tweet = tweet.strip("|")
    return tweet
#end
def replaceTwoOrMore(s):
    #look for 2 or more repetitions of character and replace with the character itself
    pattern = re.compile(r"(.)\1{1,}", re.DOTALL)
    return pattern.sub(r"\1\1", s)

def getFeatureVector(tweet):
    featureVector = []
    #split tweet into words
    words = tweet.split()
    for w in words:
        #replace two or more with two occurrences
        w = replaceTwoOrMore(w)
        #strip punctuation
        w = w.strip('\'"?,.')
        #check if the word stats with an alphabet
        val = re.search(r"^[a-zA-Z][a-zA-Z0-9]*$", w)
        #ignore if it is a stop word
        if(w in stopWords or val is None):
            continue
        else:
            featureVector.append(w.lower())
    return featureVector


def extract_features(tweet):
    tweet_words = set(tweet)
    features = {}
    for word in featureList:
        features['contains(%s)' % word] = (word in tweet_words)
    return features


def getStopWordList(stopWordListFileName):
    #read the stopwords file and build a list
    stopWords = []
    stopWords.append('AT_USER')
    stopWords.append('URL')

    fp = open(stopWordListFileName, 'r')
    line = fp.readline()
    while line:
        word = line.strip()
        stopWords.append(word)
        line = fp.readline()
    fp.close()
    return stopWords

stopWords = getStopWordList('stopword.txt')
featureList = []


# Get tweet words
tweets = []
for row in inpTweets:
    sentiment = row[0]
    tweet = row[1]
    print(row)
    processedTweet = processTweet(tweet)
    featureVector = getFeatureVector(processedTweet)
    featureList.extend(featureVector)
    print(featureVector,sentiment)

    tweets.append((featureVector, sentiment));



from pymongo import MongoClient
Client=MongoClient()
db = Client["x"]
collection = db["z"]

tweets_iterator = collection.find({},{'text':1}).sort("_id",-1).limit(25)
pcount=0
ncount=0

#deletes previous data and inserts new data
an=1
bn=1
from pymongo import MongoClient
Client=MongoClient()
db=Client["dat"]
collection=db["stor"]
db.stor.drop()
db.stor.insert({"_id":1,"values":[[0,0]]})

#deletes previous data and inserts new data
from pymongo import MongoClient
Client=MongoClient()
db=Client["dat1"]
collection=db["stor1"]
db.stor1.drop()
db.stor1.insert({"_id":1,"values1":[[0,0]]})

for a in tweets_iterator:
    text = str(a['text'])
    testTweet=text
    processedTestTweet = processTweet(testTweet)
    GetFeatureVector=getFeatureVector(processedTestTweet)
    print('Featurevector data=',GetFeatureVector)
    Extract_Features=extract_features(GetFeatureVector)
    print('Extract_Features=',Extract_Features)
    Result=NBClassifier.prob_classify(Extract_Features)
    prob_positive  = Result.prob('positive')
    prob_negative  = Result.prob('negative')
	# update using push
    from pymongo import MongoClient
    Client=MongoClient()
    db=Client["dat"]
    collection=db["stor"]
    # db.stor.drop()
    db.stor.update({"_id": 1},{"$push":{"values":[an,prob_positive]}})
    an=an+1

    # update using push
    from pymongo import MongoClient
    Client=MongoClient()
    db=Client["dat1"]
    collection=db["stor1"]
    # db.stor.drop()
    db.stor1.update({"_id":1},{"$push":{"values1":[bn,prob_negative]}})
    bn=bn+1
	
    prob_neutral   = Result.prob('neutral')
    print('Positive=',prob_positive)
    print('Negative=',prob_negative)
    print('Neutral=',prob_neutral)
#print('total=',prob_positive+prob_negative+prob_neutral)
    print(Result.max())

    # print(Result.samples())
    # print(Result.SUM_TO_ONE)
    print()
    if prob_positive>=prob_neutral and prob_positive>=prob_negative:
        print('Result=', Result.prob('positive'))
        pcount=pcount+1
        print()
    elif(prob_neutral>=prob_positive and prob_neutral>=prob_negative):
        print('Result=', Result.prob('neutral'))
        print()
    else:
         print('Result=', Result.prob('negative'))
         ncount=ncount+1
         print()
    print('result=',NBClassifier.classify(extract_features(getFeatureVector(processedTestTweet))))

poppercent=100*pcount/25
negpercent=100*ncount/25
print("Positive percent=",poppercent,"Positive count=",pcount,"Negative percent=",negpercent,"Negative count=",ncount)
from pymongo import MongoClient
Client=MongoClient()
db= Client["data"]
collection=db["data_store"]
db.data_store.update({"_id": ObjectId("597ae089cea5918c124ef468")},{"$set":{"Positive":poppercent,"Negative":negpercent,"pcount":pcount,"ncount":ncount}})
