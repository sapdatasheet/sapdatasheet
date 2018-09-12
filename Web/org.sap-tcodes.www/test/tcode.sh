#!/bin/sh

circo tcode.dot -Tsvg -o tcode-circo.svg
dot   tcode.dot -Tsvg -o tcode-dot.svg
fdp   tcode.dot -Tsvg -o tcode-fdp.svg
neato tcode.dot -Tsvg -o tcode-neato.svg
sfdp  tcode.dot -Tsvg -o tcode-sfdp.svg
twopi tcode.dot -Tsvg -o tcode-twopi.svg

echo "Finished"

