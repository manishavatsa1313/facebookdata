setwd("C:/Users/user/Desktop/rdata")
require(RCurl)
library(stringr)
library(tm)
library(ggmap)
library(dplyr)
library(plyr)
library(tm)
library(wordcloud)
library(xlsx)
library(httr)
library(igraph)
library(RWeka)

pos = readLines("positive_words.txt")
neg = readLines("negative_words.txt")


mydata <-read.xlsx("comments.xlsx", 1)

# Create corpus
corpus=Corpus(VectorSource(mydata$COMMENTS))
corpus=tm_map(corpus, removePunctuation)


# Convert to lower-case
corpus=tm_map(corpus,tolower)

# Remove stopwords
corpus=tm_map(corpus,function(x) removeWords(x,stopwords()))

corpus=tm_map(corpus, stemDocument)

# convert corpus to a Plain Text Document
corpus=tm_map(corpus,PlainTextDocument)

corpus<-data.frame(text=unlist(sapply(corpus, `[`, "content")), 
                      stringsAsFactors=F)


score.sentiment = function(sentences, pos.words, neg.words, .progress='none'){
  scores = laply(sentences,
                 function(sentence, pos.words, neg.words){
  word.list = str_split(sentence, "\\s+")
  words = unlist(word.list)
  pos.matches = match(words, pos.words)
  neg.matches = match(words, neg.words)
  pos.matches = !is.na(pos.matches)
  neg.matches = !is.na(neg.matches)
  score = sum(pos.matches) - sum(neg.matches)
  return(score)
}, pos.words, neg.words, .progress=.progress )
  scores.df = data.frame(text=sentences, score=scores)
  return(scores.df)
}
scores = score.sentiment(corpus , pos, neg, .progress='text')
scores$very.pos = as.numeric(scores$score >0)
scores$very.neg = as.numeric(scores$score <0)
global_score = round( 100 * scores$very.pos / (scores$very.pos + scores$very.neg) )
write.xlsx(scores, file="sentiment.xlsx", sheetName="Sheet2", row.name="False")
