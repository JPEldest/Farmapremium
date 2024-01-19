## SQL TEST
#### Recuperar toda la informacin de la tabla facilities.
    
ANSWER:

``
SELECT * FROM facilities;
``
   
#### Recuperar una lista que contenga el nombre y el precio de cada facility (instalaciones).

ANSWER:

``
SELECT name, membercost, guestcost FROM facilities;
``

#### Recuperar una lista con el campo name de la tabla facilities junto con un campo que indique ‘Cheap’ o ‘Expensive’ dependiendo si el coste de mantenimiento mensual es superior a 100€
ANSWER: 

``
SELECT
name,
CASE
WHEN monthlymaintenance > 100 THEN 'Expensive'
ELSE 'Cheap'
END AS cost_category
FROM facilities;
``
#### Recuperar una lista de todos los miembros (firstname, surname) que hayan recomendado a otro miembro. Asegurarse de que no existan duplicados y ordernar los resultados por surname, firstname
ANSWER:

``
SELECT DISTINCT m1.firstname, m1.surname
FROM members m1
JOIN members m2 ON m1.memid = m2.recommendedby
ORDER BY m1.surname, m1.firstname;
``
#### Sobre el ejercicio anterior, incluir en el listado el firstname y surname de por quien fue recomendado.
ANSWER:

``
    SELECT
    m1.firstname AS recommendator_firstname,
    m1.surname AS recommendator_surname,
    m2.firstname AS beeing_recommended_firstname,
    m2.surname as beeing_recomended_surname
    FROM members m1
    JOIN members m2 ON m1.memid = m2.recommendedby
    ORDER BY m2.surname, m2.firstname;
``
#### Recuperar una lista de todos los miembros, incluyendo por quien fue recomendado (si existe) sin utilizar joins.
ANSWER:

``
    SELECT
    m1.memid,
    m1.firstname,
    m1.surname,
    m1.recommendedby ,
    (SELECT CONCAT(m2.firstname, ' ', m2.surname)
    FROM members m2
    WHERE m2.memid = m1.recommendedby) AS recommended_by
    FROM members m1
    ORDER BY m1.surname, m1.firstname;
``
#### Recuperar una lista de todos los bookings por facilities y por mes que se produjeron en el 2012
ANSWER: 

``
    SELECT 
        book.bookid,
        book.facid,
        fac.name AS facility_name,
        book.memid,
        mem.firstname,
        mem.surname,
        book.starttime,
        book.slots
    FROM bookings book
    JOIN facilities fac ON book.facid = fac.facid
    JOIN members mem ON book.memid = mem.memid
    WHERE EXTRACT(YEAR FROM book.starttime) = 2012
    ORDER BY fac.name, EXTRACT(MONTH FROM book.starttime);
``
#### Calcular el número de horas totales por facility.
ANSWER:

Using only bookings table:
``
            SELECT
            facid,
            SUM(EXTRACT(EPOCH FROM slots * INTERVAL '1 hour')) / 3600 AS total_hours
            FROM bookings
            GROUP BY facid
            ORDER BY facid;
``
Using also facilities to make it more readable:
``
            SELECT
            fac.facid,
            fac.name AS facility_name,
            SUM(EXTRACT(EPOCH FROM book.slots * INTERVAL '1 hour')) / 3600 AS total_hours
            FROM bookings book
            JOIN facilities fac ON book.facid = fac.facid
            GROUP BY fac.facid, fac.name
            ORDER BY fac.name;
``
#### Calcular el total de ingresos por facility.
ANSWER:

``
        SELECT
        fac.facid,
        fac.name AS facility_name,
        SUM(
        CASE
        WHEN mem.memid = 0 THEN book.slots * fac.guestcost
        ELSE book.slots * fac.membercost
        END
        ) AS total_revenue
        FROM bookings book
        JOIN facilities fac ON book.facid = fac.facid
        LEFT JOIN members mem ON book.memid = mem.memid
        GROUP BY fac.facid, fac.name
        ORDER BY fac.facid;
``
#### Elabore una lista del número total de horas reservadas por instalación, recordando que un espacio dura media hora. La tabla de salida debe constar de la identificación de la instalación, el nombre y las horas reservadas, ordenadas por el id de la instalación. Intente formatear las horas con dos decimales.
ANSWER:

``
        SELECT
        fac.facid,
        fac.name AS facility_name,
        ROUND(SUM(book.slots) * 0.5, 2) AS total_hours_reserved
        FROM bookings book
        JOIN facilities fac ON book.facid = fac.facid
        GROUP BY fac.facid, fac.name
        ORDER BY fac.facid;
``
#### Calcule el porcentaje de utilización de cada instalación/facility por mes, ordenado por nombre y mes, redondeado a 1 decimal. El horario de apertura es a las 8 am, el horario de cierre es a las 8:30 pm. Puede tratar cada mes como un mes completo, independientemente de si hubo algunas fechas en las que el club no estuvo abierto.
ANSWER:

``
    SELECT
    fac.facid,
    fac.name AS facility_name,
    DATE_TRUNC('month', book.starttime) AS month,
    ROUND(
    (SUM(EXTRACT(EPOCH FROM (CASE
    WHEN book.starttime::TIME < '08:00:00' THEN '08:00:00'::TIME
    ELSE book.starttime::TIME
    END) - '08:00:00'::TIME) / 3600)) /
    (SUM(EXTRACT(EPOCH FROM ('20:30:00'::TIME - '08:00:00'::TIME) / 3600)) * COUNT(DISTINCT DATE_TRUNC('month', book.starttime))) * 100,
    1
    ) AS utilization_percentage
    FROM bookings book
    JOIN facilities fac ON book.facid = fac.facid
    GROUP BY fac.facid, fac.name, DATE_TRUNC('month', book.starttime)
    ORDER BY fac.facid, month;
``
#### Queremos incrementar el precio de las pistas de tenis tanto para socios como para invitados. El precio final para socios será de 6€ y de 30 para los invitados. Realizar dicha actualizacin en una única sentencia.
ANSWER:

If done using ids:

``
    UPDATE facilities
    SET membercost = 6, guestcost = 30
    WHERE facid IN (0, 1);
``

If done using name:

``
    UPDATE facilities
    SET membercost = 6, guestcost = 30
    WHERE name LIKE '%Tennis Court%';
``
#### Queremos realizar un borrado de todos los miembros que nunca hayan realizado una reserva. Cual será la sentencia?
ANSWER:

``
    DELETE FROM members
    WHERE memid NOT IN (SELECT DISTINCT memid FROM bookings);
``
#### Los números de teléfono de la base de datos tienen un formato muy irregular. Nos gustaría imprimir una lista de memid y telephone de miembros a los que se les han eliminado los caracteres '-', '(', ')' y ''. Ordenar por identificación de miembro.
ANSWER:
``
        SELECT
        memid,
        REGEXP_REPLACE(telephone, '[\s()-]', '', 'g') AS cleaned_telephone
        FROM members
        ORDER BY memid;
``
#### Busque la cadena de recomendación ascendente para el ID de miembro 27: es decir, el miembro que los recomendó y el miembro que recomendó a ese miembro, y así sucesivamente. Devuelva la identificación del miembro, el nombre y el apellido. Ordene por ID de miembro descendente.
ANSWER: 
No conocia el recursive este, me ha tocado aprender algo nuevo

        WITH RECURSIVE RecommendationChain AS (
        SELECT
        memid,
        firstname,
        surname,
        recommendedby
        FROM
        members
        WHERE
        memid = 27
    
        UNION
    
        SELECT
            m.memid,
            m.firstname,
            m.surname,
            m.recommendedby
        FROM
            members m
        JOIN
            RecommendationChain rc ON m.memid = rc.recommendedby
        )
        SELECT
        memid,
        firstname,
        surname,
        recommendedby
        FROM
        RecommendationChain
        ORDER BY
        memid DESC;

#### Genere una función que dado un ID de miembro devuelva el mismo resultado que el ejercicio anterior
ANSWER: 
In PostgreSQL:

        CREATE OR REPLACE FUNCTION GetRecommendationChain(member_id INT)
        RETURNS TABLE (
        memid INT,
        firstname VARCHAR(255),
        surname VARCHAR(255)
        ) AS $$
        BEGIN
        RETURN QUERY WITH RECURSIVE RecommendationChain AS (
        SELECT
        memid,
        firstname,
        surname,
        recommendedby
        FROM
        members
        WHERE
        memid = member_id
    
        UNION
    
        SELECT
            m.memid,
            m.firstname,
            m.surname,
            m.recommendedby
        FROM
            members m
        JOIN
            RecommendationChain rc ON m.memid = rc.recommendedby
    )
    SELECT
        memid,
        firstname,
        surname,
        recommendedby
    FROM
        RecommendationChain
    ORDER BY
        memid DESC;
    END;
    $$ LANGUAGE plpgsql;
