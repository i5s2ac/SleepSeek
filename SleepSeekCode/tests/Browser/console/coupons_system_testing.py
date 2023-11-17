from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException
import time


def create_coupon(driver):
    code_test = "159878448812"
    discount_test = "50"
    expiration_test = "12152023"

    try:
        # Establece un tiempo de espera máximo de 10 segundos
        wait = WebDriverWait(driver, 10)

        
        code = wait.until(EC.visibility_of_element_located((By.ID, 'code'))).send_keys(code_test)
        time.sleep(2)
        discount = wait.until(EC.visibility_of_element_located((By.ID, 'discount'))).send_keys(discount_test) 
        time.sleep(2) 
        expiration = wait.until(EC.visibility_of_element_located((By.ID, 'expirationDate'))).send_keys(expiration_test) 
        time.sleep(2) 
        boton = wait.until(EC.visibility_of_element_located((By.ID, 'createBtn'))).click() #boton 

    except TimeoutException:
        print("Tiempo de espera agotado. Alguno de los elementos no apareció a tiempo.")

    except NoSuchElementException:
        print("Elemento no encontrado. Puede que alguno de los elementos no exista en la página.")

def edit_coupon(driver):
    code_test = "159878448555"
    discount_test = "10"
    expiration_test = "2112024"

    try:
        # Establece un tiempo de espera máximo de 10 segundos
        wait = WebDriverWait(driver, 10)

        edit = wait.until(EC.visibility_of_element_located((By.PARTIAL_LINK_TEXT, 'Editar'))).click()

        code = wait.until(EC.visibility_of_element_located((By.NAME, 'codigo'))).clear()
        code = wait.until(EC.visibility_of_element_located((By.NAME, 'codigo'))).send_keys(code_test)
        time.sleep(2)
        discount = wait.until(EC.visibility_of_element_located((By.NAME, 'descuento'))).clear()
        discount = wait.until(EC.visibility_of_element_located((By.NAME, 'descuento'))).send_keys(discount_test) 
        time.sleep(2) 
        expiration = wait.until(EC.visibility_of_element_located((By.NAME, 'fecha_expiracion'))).clear()
        expiration = wait.until(EC.visibility_of_element_located((By.NAME, 'fecha_expiracion'))).send_keys(expiration_test) 
        time.sleep(2) 
        boton = wait.until(EC.visibility_of_element_located((By.CSS_SELECTOR, 'body > div > main > div > div > div > div > form > div > div.col-span-full.text-center > button'))).click() #boton 

    except TimeoutException:
        print("Tiempo de espera agotado. Alguno de los elementos no apareció a tiempo.")

    except NoSuchElementException:
        print("Elemento no encontrado. Puede que alguno de los elementos no exista en la página.")

def delete_coupon(driver):

    try:
        # Establece un tiempo de espera máximo de 10 segundos
        wait = WebDriverWait(driver, 10)

        delete = wait.until(EC.visibility_of_element_located((By.CLASS_NAME, 'deleteCuponBtn'))).click()

    except TimeoutException:
        print("Tiempo de espera agotado. Alguno de los elementos no apareció a tiempo.")

    except NoSuchElementException:
        print("Elemento no encontrado. Puede que alguno de los elementos no exista en la página.")