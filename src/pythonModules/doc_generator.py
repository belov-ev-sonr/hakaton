from docxtpl import DocxTemplate
from datetime import datetime
import pymysql.cursors
import sys
import os
import win32com.client


class Author:
    def __init__(self, name='Иванов Иван Иванович',
                 position='Монтажник',
                 department='ПАО «РОССЕТИ»',
                 education='Среднее специальное',
                 year_of_birth='1990',
                 experience=1):
        self.first_name = name
        self.position = position
        self.department = department
        self.education = education
        self.year_of_birth = year_of_birth
        self.experience = experience


class Expenses:
    def __init__(self, num=1, title='на работы', cost=100_000):
        self.num = num
        self.title = title
        self.cost = cost


class Deadlines:
    def __init__(self, num=1, title='делаем нечто', days='столько-то дней'):
        self.num = num
        self.title = title
        self.days = days


class Prises:
    def __init__(self, num=1, name='Иванов Иван Иванович', percentage=100):
        self.num = num
        self.name = name
        self.percentage = percentage


id_of_current_document = sys.argv[1]


users = set()
doc_1 = {}
categories = set()
expenses = set()
deadlines = set()
prises = set()

# take data from db
connection = pymysql.connect(host='84.201.147.81',
                             user='hakaton_1',
                             password='a357bgq',
                             db='hakaton',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)

try:

    with connection.cursor() as cursor:

        sql = f"SELECT * FROM hakaton.application WHERE id={id_of_current_document}"
        sql_es = connection.escape_string(sql)
        cursor.execute(sql_es)

        document = cursor.fetchall()

        for d in document:
            doc_1 = d

        sql = f"""
SELECT u.surname, u.name, u.patronymic, u.date_of_birth,  
a.percent, 
e.date_of_employment,
e2.name,
su.full_name,
p.name_position 
FROM hakaton.users u 
JOIN hakaton.applications_to_user a
ON u.id = a.id_user 
JOIN hakaton.employees e 
ON u.id = e.user_id 
JOIN hakaton.education e2 
ON e2.id = e.education_id 
JOIN hakaton.structural_units su 
ON su.id = e.structural_unit_id 
JOIN hakaton.positions p 
ON p.id = e.position_id
WHERE id_application={id_of_current_document}"""
        cursor.execute(sql)
        i = 0
        for row in cursor.fetchall():
            user = Author(
                name=f'''{row['surname']} {row['name']} {row['patronymic']} ''',
                department=row['full_name'],
                education=row['e2.name'],
                experience=int(datetime.now().strftime('%Y')) - int(row['date_of_employment'].strftime('%Y')),
                year_of_birth=row['date_of_birth'].strftime('%Y'),
                position=row['name_position']
            )
            i += 1
            price = Prises(
                num=i,
                name=f'''{row['surname']} {row['name']} {row['patronymic']} ''',
                percentage=row['percent']
            )
            users.add(user)
            prises.add(price)

        sql = f"""
SELECT codt.category 
FROM hakaton.application_to_digital_category atdc 
JOIN hakaton.categories_of_digital_transformation codt 
ON codt.id = atdc.id_digital_category  
WHERE id_application={id_of_current_document}"""
        cursor.execute(sql)

        for row in cursor.fetchall():
            categories.add(row['category'])

        sql = f"""
SELECT e.cost_item, e.sum, e.p_p 
FROM hakaton.expenditures e 
WHERE id_application={id_of_current_document}"""
        cursor.execute(sql)

        for row in cursor.fetchall():
            expense = Expenses(
                num=row['p_p'],
                title=row['cost_item'],
                cost=row['sum']
            )
            expenses.add(expense)

        sql = f"""
SELECT tfi.p_p, tfi.stage_name, tfi.days 
FROM hakaton.terms_for_implementation tfi 
WHERE id_application={id_of_current_document}"""
        cursor.execute(sql)

        for row in cursor.fetchall():
            deadline = Deadlines(
                num=row['p_p'],
                title=row['stage_name'],
                days=row['days']
            )
            deadlines.add(deadline)


finally:
    connection.close()

# setup data for context
id_of_doc = doc_1['id']


date_of_doc = doc_1['date'].strftime('%d.%m.%Y')


name_of_organization = user.department


name_of_doc = doc_1['short_title']


if len(categories) == 0:
    categories.add('не относится')
category_of_doc = categories


current_condition = doc_1['existing_disadvantages']


describe_of_solution = doc_1['solution_description']


positive_outcome = doc_1['expected_positive_effect']


value = doc_1['is_economy']
if value:
    result_of = 'создающее экономию'
else:
    result_of = 'не создающее экономию'

# load context by data
context = {
    'id_of_doc': id_of_doc,
    'date_of_doc': date_of_doc,
    'name_of_organization': name_of_organization,
    'authors': users,
    'name_of_doc': name_of_doc,
    'category_of_doc': category_of_doc,
    'current_condition': current_condition,
    'describe_of_solution': describe_of_solution,
    'positive_outcome': positive_outcome,
    'expenses': sorted(expenses, key=lambda x: x.num),
    'deadlines': sorted(deadlines, key=lambda x: x.num),
    'prises': sorted(prises, key=lambda x: x.num),
    'result_of': result_of
}


# create and fill .docx
doc = DocxTemplate(os.path.abspath("documents/template.docx"))
doc.render(context)
name_of_file = (datetime.now().strftime('%d-%m-%Y_%H-%M_id')+str(id_of_current_document))  # switch to id
doc.save(os.path.abspath("documents/" + name_of_file + ".docx"))


# create pdf from .docx
wdFormatPDF = 17

in_file = os.path.abspath("documents/" + name_of_file + ".docx")
out_file = os.path.abspath("documents/" + name_of_file + ".pdf")

word = win32com.client.DispatchEx('Word.Application')
doc = word.Documents.Open(in_file)
doc.SaveAs(out_file, FileFormat=wdFormatPDF)
doc.Close()
word.Quit()

print(name_of_file)
