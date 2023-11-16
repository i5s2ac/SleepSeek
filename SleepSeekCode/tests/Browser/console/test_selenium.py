from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException
import time

try:
    
    chrome_options = Options()
    chrome_options.add_argument("webdriver.chrome.driver=C:/Program Files/chromedriver_win32/chromedriver.exe")

    # Inicializa el navegador con las opciones
    driver = webdriver.Chrome(options=chrome_options)
    name_test = "ejemplo"
    email_test = "ejemplo@correo.com"
    password_test = "password123"

    driver.get('http://127.0.0.1:8000/register')

    try:
        # Establece un tiempo de espera máximo de 10 segundos
        wait = WebDriverWait(driver, 10)

        # Espera hasta que el elemento sea visible y pueda hacer clic en él
        name = wait.until(EC.visibility_of_element_located((By.ID, 'name'))).send_keys(name_test) #input para nombre
        time.sleep(2)
        email = wait.until(EC.visibility_of_element_located((By.ID, 'email'))).send_keys(email_test) #input para email
        time.sleep(2) 
        password = wait.until(EC.visibility_of_element_located((By.ID, 'password'))).send_keys(password_test) #input para password
        time.sleep(2) 
        password_confirmation = wait.until(EC.visibility_of_element_located((By.ID, 'password_confirmation'))).send_keys(password_test) #input para la confirmacion de contraseña
        time.sleep(2) 
        boton = wait.until(EC.visibility_of_element_located((By.CLASS_NAME, 'bg-gray-800'))).click() #boton 


    except TimeoutException:
        print("Tiempo de espera agotado. Alguno de los elementos no apareció a tiempo.")

    except NoSuchElementException:
        print("Elemento no encontrado. Puede que alguno de los elementos no exista en la página.")

finally:

    # Cierra el navegador en un bloque finally para asegurarte de que se cierre incluso si ocurre una excepción.
    if 'driver' in locals() or 'driver' in globals():
        driver.quit()
