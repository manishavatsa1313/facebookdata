setwd("C:/Users/user/Desktop/rdata")
library(ROAuth)
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

mydata <-read.xlsx("comments.xlsx", 1, comments)

# Create corpus
corpus=Corpus(VectorSource(mydata$COMMENTS))
print(corpus)


corpus=tm_map(corpus, removePunctuation)


# Convert to lower-case
corpus=tm_map(corpus,tolower)

# Remove stopwords
corpus=tm_map(corpus,function(x) removeWords(x,stopwords()))

corpus=tm_map(corpus, stemDocument)

# convert corpus to a Plain Text Document
corpus=tm_map(corpus,PlainTextDocument)

col=brewer.pal(6,"Dark2")
wordcloud(corpus, min.freq=50, max.words = Inf, scale=c(5,2),rot.per = 0.25,
          random.color=T, max.word=45, random.order=F,colors=col)


