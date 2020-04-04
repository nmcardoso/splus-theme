BUILD_NAME=build+`git rev-parse --short HEAD`

# Update version number
sed -i "2iVersion: $BUILD_NAME" style.css
git add .
git commit -m "update version"

# Create .zip file understandable by wordpress
mkdir zipball
git archive --prefix=splus-theme/ -o zipball/zipball.zip HEAD
echo $BUILD_NAME > zipball/version.txt
