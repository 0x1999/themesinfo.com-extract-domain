# _______          ____ ________  ________  ________ 
# \   _  \ ___  __/_   /   __   \/   __   \/   __   \
# /  /_\  \\  \/  /|   \____    /\____    /\____    /
# \  \_/   \>    < |   |  /    /    /    /    /    / 
#  \_____  /__/\_ \|___| /____/    /____/    /____/  
#        \/      \/                                  
# Author	: 0x1999
# Date		: 2 September 2018
# Name 		: Themesinfo.com domain extractor
# Usage 	: python scan.py https://themesinfo.com/betheme-wordpress-template-bq

# Code request from my brother panataran
# This is my first python code ;)
# 

import requests,re,sys
link = sys.argv[1]
r = requests.get(link)
totalpage=re.search(r'Theme Used on:</td><td class=\"theme_td2\">(.*?) websites</td>', r.content).group(1)
totalpage=totalpage.replace(" ", "")
page=float(totalpage)/24.0
page=int(round(page))
theme=re.search(r'Theme Name:</td><td class="theme_td2 text_bold">(.*?)</td></tr><tr><td class="theme_td">', r.content).group(1)
weblist=re.findall('<h2 class="theme_web_h2">(.*?)</h2>', r.content)
for f in list(range(1,page+1)):
	try:
		f=str(f)
		url=link+'/'+f+'/'
		r = requests.get(url)
		count = 0
		while (count < len(weblist)):
		   hasil='http://'+weblist[count]
		   print hasil
		   file = open(theme+".txt","a") 
		   file.write(hasil)
		   file.write("\n")
		   file.close()
		   count = count + 1
		print "\n"
		print "Total Domain "+str(totalpage)
		print "Grabbing "+theme+" Theme > "+theme+".txt"
		print 'Page '+f+' --------- Page '+str(page)+' Done'
		print "\n"
	except:
        	pass
