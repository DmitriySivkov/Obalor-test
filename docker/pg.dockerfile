FROM postgres:14.1

RUN apt-get update && apt-get install make

#дефолтная локаль - en_US, русскую нужно добавить, иначе, например, дамп БД
#с установленной локалью = ru не сработает
#RUN localedef -i ru_RU -c -f UTF-8 -A /usr/share/locale/locale.alias ru_RU.UTF-8
#ENV LANG ru_RU.UTF-8
