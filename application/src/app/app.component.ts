import { Component } from '@angular/core';

import { ErrorService } from './error.service';

@Component ({
  selector: 'app',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})

export class AppComponent {
  title = 'whatyalisten';
  constructor (private error: ErrorService) {}
}
