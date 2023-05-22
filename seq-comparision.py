

import urllib.request
import requests
import pandas as pd
import xml.etree.ElementTree as ET
import sys



def all_assay_info(assay_id_list):
    all_assay = {}
    for assay_id in assay_id_list:
        URL = get_url(assay_id)
        tree = get_tree(URL)
        assay_info = get_assay(assay_id, tree)
        all_assay[assay_id] = assay_info
    return all_assay

def get_assay(assay_id, tree):
    for assay_element in tree.iter('assay'):
        if assay_element.attrib['id'] == assay_id:
            assay_info = get_assay_info(assay_element)
            return assay_info
        

def get_assay_info(element):
    assay_info_dict = {}
    for assay_ele in element:
        assay_ele_key = assay_ele.attrib['name']
        assay_info_dict[assay_ele_key] = assay_ele.text
    return assay_info_dict

def get_url(assayid):
    url = 'http://f1opd.corp.life:8080/MagWebSvcs/CustomProductSearchResults.jsp'
    params = {'ProductType':'abd-gt', 'PlateId': assayid , 'Submit':'Submit'}
    r = requests.get(url = url, params = params)
    return r.url

def get_tree(url):
    response = urllib.request.urlopen(url).read()
    tree = ET.fromstring(response)
    return tree

def seq_comparision(df):
    df['Result'] = None
    sequences = ['probe_sequence1', 'probe_sequence2', 'fwd_sequence', 'rev_sequence']
    for seq in sequences:
        if len(df.loc[seq, :].unique()) == 1:
            df['Result'][seq] = 'Pass'
        else:
            df['Result'][seq] = 'Fail'
    return df


assay_list = sys.argv[1]
assay_list = "".join(assay_list.split())
assay_list = assay_list.split(',')


result_path = sys.argv[2]
result_path = result_path + "\SeqComparisionResults.xlsx"

#assay_list = ['ANT2TUD', 'ANU7MEA', 'ANWDFX7']
#result_path = r'C:\Users\dhvani.patel\Desktop\OpenArray\Tools\seq-comparision-results.xlsx'

assay_dict = all_assay_info(assay_list)
df= pd.DataFrame(assay_dict)
df = seq_comparision(df)



with pd.ExcelWriter(result_path) as writer:  
    df.to_excel(writer)







