import 'package:flutter_bloc/flutter_bloc.dart';
import 'cart_event.dart';
import 'cart_state.dart';
import '../../models/product.dart';

/// CartBloc handles all cart-related business logic
/// It listens to CartEvents and emits new CartStates
class CartBloc extends Bloc<CartEvent, CartState> {
  CartBloc() : super(const CartState()) {
    // Register event handlers
    on<AddToCartEvent>(_onAddToCart);
    on<RemoveFromCartEvent>(_onRemoveFromCart);
    on<ClearCartEvent>(_onClearCart);
  }

  /// Handles AddToCartEvent: adds one unit of the product to cart
  void _onAddToCart(AddToCartEvent event, Emitter<CartState> emit) {
    final updatedItems = List<Product>.from(state.cartItems)
      ..add(event.product);
    emit(state.copyWith(cartItems: updatedItems));
  }

  /// Handles RemoveFromCartEvent: removes one unit of the product from cart
  void _onRemoveFromCart(RemoveFromCartEvent event, Emitter<CartState> emit) {
    final updatedItems = List<Product>.from(state.cartItems);
    // Find last occurrence and remove it (to decrement by 1)
    final indexToRemove =
        updatedItems.lastIndexWhere((p) => p.id == event.product.id);
    if (indexToRemove != -1) {
      updatedItems.removeAt(indexToRemove);
    }
    emit(state.copyWith(cartItems: updatedItems));
  }

  /// Handles ClearCartEvent: removes all items from cart
  void _onClearCart(ClearCartEvent event, Emitter<CartState> emit) {
    emit(const CartState());
  }
}
