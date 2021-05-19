import random
import os
import csv

iD = []
password = []
user_type = []
email_address = []
enrol_date = []
last_access = []


f = open("users1.txt","a+")
f2 = open("users2.txt","a+")
f3 = open("users3.txt","a+")
f4 = open("users4.txt","a+")

string = ('INSERT INTO users(user_id,password,user_type,email_address,enrol_date,last_access)')

string3 = "\nVALUES"

def createValues(iD, password, user_type,email_address,enrol_date,last_access):
    
    str2 = "("
    str2 += iD
    str2 += ","
    str2 += "MD5"
    str2 += "('"
    str2 += password
    str2 += "')"
    str2 += ","
    str2 += "'"
    str2 += user_type
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += email_address
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += enrol_date
    str2 += "'"
    str2 += ","
    str2 += "'"
    str2 += last_access
    str2 += "'"
    str2 += "),"

    
    return str2

pos = -1;

with open("data2.csv", "r") as csv_file:
    reader = csv.reader(csv_file)
    for row in reader:
        if(pos==-1):
            next
        else:
            iD.append(row[0])
            password.append(row[1])
            user_type.append(row[2])
            email_address.append(row[3])
            enrol_date.append(row[4])
            last_access.append(row[5])
            
                
        pos += 1
    csv_file.close()

x = 0

f.write(string)
f.write(string3)
while(x<=250):
    f.write(str(createValues(iD[x],random.choice(password), random.choice(user_type), random.choice(email_address), random.choice(enrol_date), random.choice(last_access))))
    x+=1

f.seek(0, os.SEEK_END) 
f.seek(f.tell() -1, os.SEEK_SET)
f.truncate()
f.write(";")

f2.write(string)
f2.write(string3)
while(x<=500):
    f2.write(str(createValues(iD[x],random.choice(password), random.choice(user_type), random.choice(email_address), random.choice(enrol_date), random.choice(last_access))))
    x+=1
    
f2.seek(0, os.SEEK_END) 
f2.seek(f.tell() -1, os.SEEK_SET)
f2.truncate()
f2.write(";")

f3.write(string)
f3.write(string3)
while(x<=750):
    f3.write(str(createValues(iD[x],random.choice(password), random.choice(user_type), random.choice(email_address), random.choice(enrol_date), random.choice(last_access))))
    x+=1
    
f3.seek(0, os.SEEK_END) 
f3.seek(f.tell() -1, os.SEEK_SET)
f3.truncate()
f3.write(";")
    
    
f4.write(string)
f4.write(string3)

while(x<=999):
    f4.write(str(createValues(iD[x],random.choice(password), random.choice(user_type), random.choice(email_address), random.choice(enrol_date), random.choice(last_access))))
    x+=1
    
f4.seek(0, os.SEEK_END) 
f4.seek(f.tell() -1, os.SEEK_SET)
f4.truncate()
f4.write(";")
    

f.close()
f2.close()
f3.close()
f4.close()