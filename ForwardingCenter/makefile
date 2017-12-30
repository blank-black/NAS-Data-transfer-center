SRCS = $(wildcard *.cpp)
BUILD = $(patsubst %.cpp, %, $(SRCS))
CC = g++
CXXFLAGS = -g -Wall -O -std=c++11

MYSQLLIB = -lmysqlclient -lm -lpthread
MYSQLPATH = -I/usr/include/mysql -L/usr/lib64/mysql

.cpp:
	$(CC) -o $@ $< $(CXXFLAGS) $(MYSQLLIB) $(MYSQLPATH)

all: $(BUILD)

.PHONY : clean
clean:
	$(RM) $(BUILD)
