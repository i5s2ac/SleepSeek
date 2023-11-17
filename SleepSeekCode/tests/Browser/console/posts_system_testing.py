from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException
import time


def create_post(driver):
    title_test = "titulo ejemplo"
    info_test = "Contenido de ejemplo para un post"

    try:
        # Establece un tiempo de espera máximo de 10 segundos
        wait = WebDriverWait(driver, 10)

        
        title = wait.until(EC.visibility_of_element_located((By.ID, 'PostNameX'))).send_keys(title_test)
        time.sleep(2)
        info = wait.until(EC.visibility_of_element_located((By.ID, 'PostInfoX'))).send_keys(info_test) 
        time.sleep(2) 
        boton = wait.until(EC.visibility_of_element_located((By.ID, 'createBtnPost'))).click() #boton 

    except TimeoutException:
        print("Tiempo de espera agotado. Alguno de los elementos no apareció a tiempo.")

    except NoSuchElementException:
        print("Elemento no encontrado. Puede que alguno de los elementos no exista en la página.")

def to_edit_post(driver):

    try:
        # Establece un tiempo de espera máximo de 10 segundos
        wait = WebDriverWait(driver, 10)
        boton = wait.until(EC.visibility_of_element_located((By.CSS_SELECTOR, 'a.bg-blue-500[href*="/edit"]'))).click() #boton 
        edit_post(driver)


    except TimeoutException:
        print("Tiempo de espera agotado. Alguno de los elementos no apareció a tiempo.")

    except NoSuchElementException:
        print("Elemento no encontrado. Puede que alguno de los elementos no exista en la página.")

def edit_post(driver):
    title_test = "Ejemplo de edit"
    info_test = "este post fue editado"

    try:
        # Establece un tiempo de espera máximo de 10 segundos
        wait = WebDriverWait(driver, 10)

        title = wait.until(EC.visibility_of_element_located((By.NAME, 'PostName'))).clear()
        title = wait.until(EC.visibility_of_element_located((By.NAME, 'PostName'))).send_keys(title_test)
        time.sleep(2)
        info = wait.until(EC.visibility_of_element_located((By.NAME, 'PostInfo'))).clear() 
        info = wait.until(EC.visibility_of_element_located((By.NAME, 'PostInfo'))).send_keys(info_test) 
        time.sleep(2) 
        boton = wait.until(EC.visibility_of_element_located((By.CSS_SELECTOR, 'button.w-full.p-4.mt-4.bg-blue-500'))).click() #boton 

    except TimeoutException:
        print("Tiempo de espera agotado. Alguno de los elementos no apareció a tiempo.")

    except NoSuchElementException:
        print("Elemento no encontrado. Puede que alguno de los elementos no exista en la página.")

def delete_post(driver):
    

    try:
        # Establece un tiempo de espera máximo de 10 segundos
        wait = WebDriverWait(driver, 10)
        boton = wait.until(EC.visibility_of_element_located((By.CLASS_NAME, 'deletePostBtn'))).click() #boton 

    except TimeoutException:
        print("Tiempo de espera agotado. Alguno de los elementos no apareció a tiempo.")

    except NoSuchElementException:
        print("Elemento no encontrado. Puede que alguno de los elementos no exista en la página.")