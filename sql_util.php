<?php 
#Funciones util para generar el sql

function getFNames( $fields, $bindings ) 
{
    $res = array();
    foreach ( $fields as $fn ) 
    {
        if ( array_key_exists( $fn, $bindings ) )
        {
            $res[] = $bindings[$fn];
        }
        else
        {
            $res[] = $fn;
        }
    }
    return $res;
}

function getSelect( $table, $whereFields = array() ) 
{
    $fs = implode( ', ', $table['fields'] );

    # Where
    $where = '';
    if ( count( $whereFields ) != 0 )
    {
        $where .= ' where ';
        for ( $i = 0, $size = count( $whereFields ),  $last = $size - 1; $i < $size; $i++ )
        {
            $wf = $whereFields[$i];
            if ( is_array( $wf ) )
            { # %field% %cmp% :%field% [and]
                $where .= $wf[0] . $wf[1] . ' :' . $wf[0];
                $where .= ( $i == $last ? '' : ' and ');
            }
            else
            { # %field% = :%field% [and]
                $where .= $wf . ' = :' . $wf . ( $i == $last ? '' : ' and ' );
            }
        }
    }

    # Order by
    if ( isset( $table['order'] ) ) 
    {
        $obs = array();
        foreach ( $table['order'] as $pos ) 
        {
            $obs[] = $table['fields'][$pos];
        }
        $ob = ' order by ' . implode( ", ", $obs );
    } 
    else 
    {
        $ob = ""; 
    }
    return "select " . $fs . " from " . $table['name'] . $where . ' ' . $ob;
}

function getSelectByIds( $table ) {
    $where = array();
    foreach ( $table['ids'] as $f ) 
    {
        $where[] = $table['fields'][$f];
    }

    return getSelect( $table, $where );
}

function getInsert( $table )
{
    $fs = implode( ', ', $table['fields'] );
    $qm = array();
    foreach ( $table['fields'] as $com ) 
    {
        if ( array_key_exists( $com, $table['form'] ) ) 
        {
            $com = $table['form'][$com];
        }
        $qm[] = ':' . $com;
    }
    $qm = implode( ',' , $qm );
    return 'insert into ' . $table['name'] . ' (' . $fs . ') values (' . $qm . ')';
}

function getUpdate( $table )
{
    # Construyendo los sets: campo = :campo
    $us = '';
    for ( $i = 0, $size = count ( $table['fields'] ), $last = $size - 1 ; $i < $size; $i++ ) 
    {
        if ( array_key_exists( $i, $table['ids'] ) )
        {
            # No hacer nada   
        }
        else 
        {
            $fn = $table['fields'][$i];
            $us .= $fn . ' = '; # Concatenar el nombre del campo
            if ( array_key_exists( $fn, $table['form'] ) )
            {
                $fn = $table['form'][$fn];
            } 
            $us .= ':' . $fn . ( $i == $last ? '' : ', ') ;
        }
    }
    # Construir los where campo = :campo
    $where = ' where ';
    for ( $i = 0, $size = count( $table['ids'] ), $last = $size - 1; $i < $size; $i++ )
    {
        $pid = $table['ids'][$i]; # Obtener posicion del campo que es Identificador
        $fw = $table['fields'][$pid]; # Obtener el nombre del campo Identificador
        $where .= $fw . ' = ';
        if ( array_key_exists( $fw, $table['form'] ) )
        {
            $fw = $table['form'][$fw];
        }
        # Agregar el comodin y concatenar un and si sigue otro parametro
        $where .= ':' . $fw . ( $i == $last ? '' : ' and '); 
    }
    return 'update ' . $table['name'] . ' set ' . $us . $where;
}

function getDelete( $table ) {
    # Lanzar una exception si la tabla no cuenta con identificadores.
    # De otro modo se estaría eliminando todo el contenido de la tabla.
    $ds = '';
    for ( $i = 0, $size = count( $table['ids'] ), $last = $size - 1; $i < $size; $i++ ) 
    {
        # El nombre al que apunta el identificador
        $fn = $table['fields'][ $table['ids'][$i] ]; 

        if ( array_key_exists( $fn, $table['form'] ) )
        { 
            $nn = $table['form'][$fn]; # El campo se llama de otro modo en el formulario
        }
        else 
        {
            $nn = $fn; # El campo se llama igual
        }
        $ds .= $fn . ' = :' . $nn . ( $i == $last ? '' : ' and ' ); 
    }
    return 'delete from ' . $table['name'] . ' where ' . $ds;
}
?>