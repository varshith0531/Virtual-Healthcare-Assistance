s="(((([]))))"
l=[s[0]]
for i in range(1,len(s)):
    if l[-1]!=s[i]:
        l.append(s[i])
    else:
        l=l[:-1]
print(l)

