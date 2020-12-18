BUILD_NAME=build+`git rev-parse --short HEAD`

# Create .zip file understandable by wordpress
mkdir zipball
git archive --prefix=splus-theme/ -o zipball/zipball.zip HEAD
echo $BUILD_NAME > zipball/version.txt
