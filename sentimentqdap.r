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
library(qdap)


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

score.sentiment = function(sentences, .progress='none'){
  scores = laply(sentences,
                 function(sentence){
                   word.list = str_split(sentence, "\\s+")
                   words = unlist(word.list)
                   score=counts(polarity(word.list))
                   return(score)
                 }, .progress=.progress )
  scores.df = data.frame(text=sentences,score=scores)
  return(scores.df)
}

paste3 <- function(x, sep = ", "){
  sapply(x, paste, collapse = sep)
}

condense <- function(dataframe, ...) {
  whichlist <- sapply(dataframe, is.list)
  dataframe[, whichlist] <- sapply(dataframe[, whichlist], paste3, ...)
  dataframe
}

scores = score.sentiment(corpus, .progress='text')
write.xlsx(condense(scores) , file="sentiment.xlsx", sheetName="Sheet2", row.name="False")