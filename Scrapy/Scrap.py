from newspaper import Article

url = input('Please input URL of the site: ')
lang = input('Please input your language, en - English...')

a = Article(url, language=lang)

a.download()
a.parse()

output = open("Output.txt", "w")
output.write(a.title and a.text)
output.write(a.top_image)
output.close()