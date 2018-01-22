import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';

import { AppComponent } from './app.component';
import { SearchComponent } from './search/search.component';
import { TrackComponent } from './track/track.component';

import { ApiService } from './api.service';
import { ErrorService } from './error.service';
import { AppRoutingModule } from './/app-routing.module';

@NgModule ({
  declarations: [
    AppComponent,
    SearchComponent,
    TrackComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    CommonModule,
    HttpClientModule,
    AppRoutingModule,
  ],
  providers: [
    ApiService,
    ErrorService,
  ],
  bootstrap: [ AppComponent ]
})

export class AppModule { }
