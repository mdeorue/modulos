<?php

class Usuario extends Seeder {

	public function run()
    {
        DB::table('sb_usuario')->delete();


        $usuarios = array(
            array(
        		'rut' 			=> '16794318710',
        		'usuario' 		=> 'MIGUEL MATIAS DE ORUE DIAZ',
        		'categoria' 	=> 2,
        		'password'		=> Hash::make('matias1987'),
        		'email' 		=> 'mdeorue01@ufromail.cl',
        		'created_at'	=> date('Y-m-d H:i:s'),
        		'updated_at'	=> date('Y-m-d H:i:s')
        	)
        );

        DB::table('sb_usuario')->insert( $usuarios );
    }

}