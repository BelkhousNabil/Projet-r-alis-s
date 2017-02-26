TEX = pdflatex
RM = rm -rf

SRC = $(wildcard *.tex)
FILES = $(SRC:.tex=.pdf)

all: $(FILES)

%.pdf: %.tex
	$(TEX) $<
	$(TEX) $<
	$(RM) *.aux *.log *.toc *.out

clean:
	$(RM) *.pdf *.aux *.log *.toc *.out
