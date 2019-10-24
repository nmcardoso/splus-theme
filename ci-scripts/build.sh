mkdir zipball
git archive --prefix=splus-theme/ -o zipball/zipball.zip HEAD
echo 'build+'`git rev-parse --short HEAD` > zipball/version.txt

