import random
import os
import csv

iD = []
salutation = []
firstName = []
lastName = []
streetAd = []
streetAd2 = []
post = []
primPhone = []
secPhone = []
facNum = []
city = []
province = []
preferredContMet = []

f = open("data.txt","a+")
f2 = open("data2.txt","a+")
f3 = open("data3.txt","a+")
f4 = open("data4.txt","a+")

string = ('INSERT INTO persons(user_id,salutation, first_name, last_name,'
         'street_address1, street_address2, city, province, postal_code,'
         'primary_phone_number,'
         'secondary_phone_number, fax_number, preferred_contact_method)')

string3 = "\nVALUES"

def createValues(iD, salutation, firstName, lastName, streetAd, streetAd2, city, province, post,
                primPhone, secPhone, facNum,  preferredContMet):
    
    str2 = "("
    str2 += iD
    str2 += ","
    str2 += "'"
    str2 += salutation
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += firstName
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += lastName
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += streetAd
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += streetAd2
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += city
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += province
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += post
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += primPhone
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += secPhone
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += facNum
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += preferredContMet
    str2 += "'"
    str2 += "),"

    
    return str2

pos = -1;

with open("data.csv", "r") as csv_file:
    reader = csv.reader(csv_file)
    for row in reader:
        if(pos==-1):
            next
        else:
            iD.append(row[0])
            salutation.append(row[1])
            firstName.append(row[2])
            lastName.append(row[3])
            streetAd.append(row[4])
            streetAd2.append(row[5])
            city.append(row[6])
            province.append(row[7])
            post.append(row[8])
            primPhone.append(row[9])
            secPhone.append(row[10])
            facNum.append(row[11])
            preferredContMet.append(row[12])
            
                
        pos += 1
    csv_file.close()

x = 0

f.write(string)
f.write(string3)
while(x<=250):
    f.write(str(createValues(iD[x],random.choice(salutation), random.choice(firstName), random.choice(lastName), random.choice(streetAd), random.choice(streetAd2),random.choice(city), random.choice(province), random.choice(post), random.choice(primPhone), random.choice(secPhone),random.choice(facNum),random.choice(preferredContMet))))
    x+=1

f.seek(0, os.SEEK_END) 
f.seek(f.tell() -1, os.SEEK_SET)
f.truncate()
f.write(";")

f2.write(string)
f2.write(string3)
while(x<=500):
    f2.write(str(createValues(iD[x],random.choice(salutation), random.choice(firstName), random.choice(lastName), random.choice(streetAd), random.choice(streetAd2),random.choice(city), random.choice(province), random.choice(post), random.choice(primPhone), random.choice(secPhone),random.choice(facNum),random.choice(preferredContMet))))
    x+=1
    
f2.seek(0, os.SEEK_END) 
f2.seek(f.tell() -1, os.SEEK_SET)
f2.truncate()
f2.write(";")

f3.write(string)
f3.write(string3)
while(x<=750):
    f3.write(str(createValues(iD[x],random.choice(salutation), random.choice(firstName), random.choice(lastName), random.choice(streetAd), random.choice(streetAd2),random.choice(city), random.choice(province), random.choice(post), random.choice(primPhone), random.choice(secPhone),random.choice(facNum),random.choice(preferredContMet))))
    x+=1
    
f3.seek(0, os.SEEK_END) 
f3.seek(f.tell() -1, os.SEEK_SET)
f3.truncate()
f3.write(";")
    
    
f4.write(string)
f4.write(string3)

while(x<=999):
    f4.write(str(createValues(iD[x],random.choice(salutation), random.choice(firstName), random.choice(lastName), random.choice(streetAd), random.choice(streetAd2),random.choice(city), random.choice(province), random.choice(post), random.choice(primPhone), random.choice(secPhone),random.choice(facNum),random.choice(preferredContMet))))
    x+=1
    
f4.seek(0, os.SEEK_END) 
f4.seek(f.tell() -1, os.SEEK_SET)
f4.truncate()
f4.write(";")
    

f.close()
f2.close()
f3.close()
f4.close()