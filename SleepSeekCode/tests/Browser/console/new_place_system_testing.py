from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException
from selenium.webdriver.support.ui import Select
import time


def new_place(driver):

    title_test = "Serene Haven Retreat"
    description_test = "Bienvenidos a un oasis de elegancia y tranquilidad en Serene Haven Retreat."
    location_test = "Serenity Valley, nestled among the Mystical Mountains"
    date_start_test = "15112023"
    date_end_test = "5112023"
    status_test = "disponible"
    boost_test = "1"

    try:
        
        wait = WebDriverWait(driver, 10)

        title = wait.until(EC.visibility_of_element_located((By.ID, 'title'))).send_keys(title_test)
        time.sleep(2)
        description = wait.until(EC.visibility_of_element_located((By.ID, 'description'))).send_keys(description_test) 
        time.sleep(2) 
        location = wait.until(EC.visibility_of_element_located((By.ID, 'location'))).send_keys(location_test) 
        time.sleep(2)
        start_date = wait.until(EC.visibility_of_element_located((By.ID, 'date_start'))).send_keys(date_start_test)
        time.sleep(2)
        end_date = wait.until(EC.visibility_of_element_located((By.ID, 'date_end'))).send_keys(date_end_test)
        time.sleep(2)
        status = wait.until(EC.visibility_of_element_located((By.ID, 'status')))
        select = Select(status)
        select.select_by_value(status_test)
        time.sleep(2) 
        boost = wait.until(EC.visibility_of_element_located((By.ID, 'boost')))
        select = Select(boost)
        select.select_by_value(boost_test)
        boton = wait.until(EC.visibility_of_element_located((By.ID, 'createBtnReserva'))).click() 

    except TimeoutException:
        print("Tiempo de espera agotado. Alguno de los elementos no apareció a tiempo.")

    except NoSuchElementException:
        print("Elemento no encontrado. Puede que alguno de los elementos no exista en la página.")