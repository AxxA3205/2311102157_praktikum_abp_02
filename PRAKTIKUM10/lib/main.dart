import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'bloc/cart/cart_bloc.dart';
import 'screens/product/product_list_screen.dart';

void main() {
  runApp(const SportShopApp());
}

class SportShopApp extends StatelessWidget {
  const SportShopApp({super.key});

  @override
  Widget build(BuildContext context) {
    // BlocProvider: menyediakan CartBloc ke seluruh widget tree
    return BlocProvider<CartBloc>(
      create: (context) => CartBloc(),
      child: MaterialApp(
        title: 'Sport Shop',
        debugShowCheckedModeBanner: false,
        theme: ThemeData(
          colorScheme: ColorScheme.fromSeed(
            seedColor: const Color(0xFF1F6FEB),
            brightness: Brightness.dark,
          ),
          useMaterial3: true,
          fontFamily: 'Roboto',
          scaffoldBackgroundColor: const Color(0xFF0D1117),
        ),
        home: const ProductListScreen(),
      ),
    );
  }
}
